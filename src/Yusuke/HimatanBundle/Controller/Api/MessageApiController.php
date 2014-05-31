<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/31
 * Time: 10:30
 */
namespace Yusuke\HimatanBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Yusuke\HimatanBundle\Entity\UserMessage;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Controller\AppController;

/**
 * MessageApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/message")
 */
class MessageApiController extends AppController
{
    public function checkPostValue(Request $request, array $names)
    {
        foreach ($names as $name){
            if (!$request->get($name)) throw new ClientErrorException('invalidPostValue');
        }
    }

    public function getRequestPost(Request $request, $validateName, UserMessage $message = NULL, $filePath = NULL)
    {
        if (!$message) $message = new UserMessage();
        $message
            ->setToUserId(((int)$request->get('toUserId')) ?: $message->getToUserId())
            ->setFromUserId(((int)$request->get('fromUserId')) ?: $message->getFromUserId())
            ->setText(($request->get('text')) ?: $message->getText())
            ->setImg(($filePath) ?: NULL)
        ;
        $this->validate($message, $validateName);
        return $message;
    }

    public function validate(UserMessage $message, $validateName)
    {
        $errors = $this->get('validator')->validate($message, $validateName);
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue');
    }

    /**
     * @Route("/setMessage",defaults={"_format"="json"},name="api_message_setMessage")
     * @Template
     */
    public function setMessageAction(Request $request)
    {
        $this->checkRestMethod($request);
        $this->checkPostValue($request, array('fromUserId','toUserId'));
        $fileName = NULL;

        if ($file = $request->files->get('img')){
            $fileUploadService = $this->get('file_upload_service');
            $fileName = $fileUploadService->uploadMessageImg($file);
        }

        $message = $this->getRequestPost($request, 'set_message_api', NULL, $fileName);

        $this->get('doctrine')->getRepository('YusukeHimatanBundle:UserMessage')->setMessage($message);
        return array();



    }


}