<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/26
 * Time: 16:02
 */
namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Entity\User;
use Yusuke\HimatanBundle\Entity\UserImg;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Controller\AppController;

/**
 * UserApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/user")
 */
class UserApiController extends AppController
{
    public function checkPostValue(Request $request, array $names)
    {
        foreach ($names as $name){
            if (!$request->get($name)) throw new ClientErrorException('invalidPostValue');
        }
    }

    public function getRequestUser(Request $request, $validateName, User $user = NULL)
    {
        if (!$user) $user = new User();
        $user
            ->setAreaId(((int)$request->get('areaId')) ?: $user->getAreaId())
            ->setAge(((int)$request->get('age')) ?: $user->getAge())
            ->setDevice(((int)$request->get('device')) ?: $user->getDevice())
            ->setSex(((int)$request->get('sex')) ?: $user->getSex())
            ->setName(($request->get('name')) ?: $user->getName())
            ->setVersion(($request->get('version')) ?: $user->getVersion())
            ->setIntroduction(($request->get('introduction')) ?: $user->getIntroduction())
            ->setToken(($request->get('token')) ?: $user->getToken())
        ;
        $this->validate($user, $validateName);
        return $user;
    }

    public function validate(User $user, $validateName)
    {
        $errors = $this->get('validator')->validate($user, $validateName);
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue');
    }

    /**
     * @Route("/setUser",defaults={"_format"="json"},name="api_user_setUser")
     * @Template
     */
    public function setUserAction(Request $request)
    {
        $this->checkRestMethod($request);
        $this->checkPostValue($request, array('device','version'));
        $user = $this->getRequestUser($request, 'set_user_api');

        $userRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:User');
        $user = $userRepository->setUser($user);

        return array(
            'userId' => $user->getId(),
        );
    }

    /**
     * @Route("/getUser",defaults={"_format"="json"},name="api_user_getUser")
     * @Template
     */
    public function getUserAction(Request $request)
    {
        $this->checkRestMethod($request);
        $this->checkPostValue($request, array('id'));

        $userRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:User');
        $user = $userRepository->selectUser($request->get('id'));

        $userImgRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:UserImg');
        $userImgs = $userImgRepository->selectUserImg($request->get('id'));

        $userLikeRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:UserLike');
        $userLike = $userLikeRepository->selectUserLike($request->get('id'));

        return array(
            'User' => $user,
            'UserImgs' => $userImgs,
            'UserLike' => $userLike,
        );
    }

    /**
     * @Route("/updateUser",defaults={"_format"="json"},name="api_user_updateUser")
     * @Template
     */
    public function updateUserAction(Request $request)
    {
        $this->checkRestMethod($request);
        $this->checkPostValue($request, array('id','sex','age','areaId','name','introduction'));

        $userRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:User');
        $user = $userRepository->selectUser($request->get('id'));

        $this->getRequestUser($request, 'update_user', $user);

        $userRepository->setUser($user);

        $fileUploadService = $this->get('file_upload_service');
        $picFileParams = array('img1','img2','img3','img4');
        foreach ($picFileParams as $params){
            if ($file = $request->files->get($params)){
                $number = (int)str_replace("img","",$params);
                $fileUploadService->upload($file, $number, $id);
            }
        }
        return array();
    }
}