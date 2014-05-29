<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/25
 * Time: 19:40
 */
namespace Yusuke\HimatanBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\ExceptionInterface;

class ClientErrorException extends HttpException implements ExceptionInterface
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
        parent::__construct(200, $message, null, array(), 0);
    }

    public function getExceptionMessage()
    {
        return $this->message;
    }
}