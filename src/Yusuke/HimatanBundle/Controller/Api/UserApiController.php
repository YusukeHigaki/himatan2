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
    /**
     * @Route("/setUser",defaults={"_format"="json"},name="api_user_setUser")
     * @Template
     */
    public function setUserAction(Request $request)
    {
        $this->checkRestMethod($request);

        if (!$device = (int)$request->get('device')) throw new ClientErrorException('invalidPostValue');
        if (!$version = $request->get('version')) throw new ClientErrorException('invalidPostValue');

        $user = new User();
        $user
            ->setDevice($device)
            ->setVersion($version)
            ->setToken($request->get('token'))
            ;
        $errors = $this->get('validator')->validate($user, array('set_user_api'));
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue');

        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($user);
        $em->flush();

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

        if (!$id = (int)$request->get('id')) throw new ClientErrorException('invalidPostValue');

        $userRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:User');
        $user = $userRepository->selectUser($id);

        $userImgRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:UserImg');
        $userImgs = $userImgRepository->selectUserImg($id);

        $userLikeRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:UserLike');
        $userLike = $userLikeRepository->selectUserLike($id);

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

        if (!$id = (int)$request->get('id')) throw new ClientErrorException('invalidPostValue');
        if (!$sex= (int)$request->get('sex')) throw new ClientErrorException('invalidPostValue');
        if (!$age = (int)$request->get('age')) throw new ClientErrorException('invalidPostValue');
        if (!$areaId = (int)$request->get('areaId')) throw new ClientErrorException('invalidPostValue');
        if (!$name = $request->get('name')) throw new ClientErrorException('invalidPostValue');
        if (!$introduction = $request->get('introduction')) throw new ClientErrorException('invalidPostValue');

        $userRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:User');
        $user = $userRepository->selectUser($id);

        $user
            ->setSex($sex)
            ->setAge($age)
            ->setAreaId($areaId)
            ->setName($name)
            ->setIntroduction($introduction)
            ;
        $errors = $this->get('validator')->validate($user, array('update_user_api'));
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue8');
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