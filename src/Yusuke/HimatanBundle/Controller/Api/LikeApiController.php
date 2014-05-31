<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/29
 * Time: 13:04
 */
namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Entity\UserLike;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Controller\AppController;

/**
 * LikeApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/like")
 */
class LikeApiController extends AppController
{
    public function checkLikeValue(Request $request, array $names)
    {
        foreach ($names as $name){
            if (!$request->get($name)) throw new ClientErrorException('invalidPostValue');
        }
    }

    public function getRequestLike(Request $request, $validateName, UserLike $like = NULL)
    {
        if(!$like) $like = new UserLike();
        $like
            ->setFromUser(($request->get('fromUser')) ?: $like->getFromUser())
            ->setToUser(($request->get('toUser')) ?: $like->getToUser())
        ;
        $this->validate($like, $validateName);
        return $like;
    }

    public function validate(UserLike $like, $validateName)
    {
        $errors = $this->get('validator')->validate($like, $validateName);
        if (count($errors) >0 ) throw new ClientErrorException('invalidPostValue');
    }


    /**
     * @Route("/setLike",defaults={"_format"="json"},name="api_like_setLike")
     * @Template
     */
    public function setLikeAction(Request $request)
    {
        $this->checkRestMethod($request);

        if (!$toUserId = (int)$request->get('toUser')) throw new ClientErrorException('invalidPostValue');
        if (!$fromUserId = (int)$request->get('fromUser')) throw new ClientErrorException('invalidPostValue');

        $like = new UserLike();
        $like
            ->setToUserId($toUserId)
            ->setFromUserId($fromUserId)
        ;
        $errors = $this->get('validator')->validate($like, array('set_like_api'));
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue');

        $userLikeRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:UserLike');
        $userLikeRepository->setLike($like);

        return array();
    }

}