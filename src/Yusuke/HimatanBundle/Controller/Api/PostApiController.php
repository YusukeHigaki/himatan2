<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/29
 * Time: 13:30
 */
namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Entity\UserPost;
use Yusuke\HimatanBundle\Entity\UserArea;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Controller\AppController;

/**
 * PostApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/post")
 */
class PostApiController extends AppController
{


    public function checkPostValue(Request $request, array $names)
    {
        foreach ($names as $name){
            if (!$request->get($name)) throw new ClientErrorException('invalidPostValue');
        }
    }

    public function getRequestPost(Request $request, $validateName, UserPost $post = NULL)
    {
        if (!$post) $post = new UserPost();
        $post
            ->setUserId(((int)$request->get('userId')) ?: $post->getUserId())
            ->setText(($request->get('text')) ?: $post->getText())
        ;
        $this->validatePost($post, $validateName);
        return $post;
    }

    public function validatePost(UserPost $post, $validateName)
    {
        $errors = $this->get('validator')->validate($post, $validateName);
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue');
    }

    public function validateArea(UserArea $area, $validateName)
    {
        $errors = $this->get('validator')->validate($area, $validateName);
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue');
    }

    /**
     * @Route("/setPost",defaults={"_format"="json"},name="api_post_setPost")
     * @Template
     */
    public function setPostAction(Request $request)
    {
        $this->checkRestMethod($request);
        $this->checkPostValue($request, 'userId','text','area');
        $post = $this->getRequestPost($request, 'set_post_api');

        $userPostRepository = $this->get('doctrine')->getRepository('YusukeHimatanBundle:UserPost');
        $userPostRepository->setPost($post);

        return array();
    }

    /**
     * @Route("/getPost",defaults={"_format"="json"},name="api_post_getPost")
     * @Template
     */
    public function getPostAction(Request $request)
    {
        $this->checkRestMethod($request);

        $postId = ($request->get('postId')) ?: NULL;
        $posts = $this->get('PostService')->selectPosts($this->container->getParameter('timeline_limit'), $postId);

        return array(
            'Posts' => $posts,
        );
    }

}