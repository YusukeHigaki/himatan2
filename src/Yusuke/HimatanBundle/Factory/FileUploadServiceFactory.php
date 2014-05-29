<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/27
 * Time: 14:55
 */

namespace Yusuke\HimatanBundle\Factory;


class FileUploadServiceFactory
{
    public function get()
    {
        $fileUploadService = new fileUploadService();
        return $fileUploadService;
    }
} 