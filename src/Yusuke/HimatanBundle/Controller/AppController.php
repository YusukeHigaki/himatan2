<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/14
 * Time: 13:58
 */
namespace Yusuke\HimatanBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\bundle\FrameworkBundle\Controller\Controller;
use Yusuke\HimatanBundle\Exception\ClientErrorException;

/**
 * AppController.
 */
abstract class AppController extends Controller
{
    public function checkRestMethod(Request $request)
    {
        if ('POST' != $request->getMethod()) throw new ClientErrorException('invalidRestMethod');
    }
}
