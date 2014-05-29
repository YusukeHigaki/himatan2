<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/27
 * Time: 12:02
 */
namespace Yusuke\HimatanBundle\Service;

use Yusuke\HimatanBundle\Component\ImageFile;
use Yusuke\HimatanBundle\Exception\SystemErrorException;

/**
 * S3UploadService.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 */
class S3uploadService
{
    private $awsS3;

    private $bucket;

    /**
     * Constructor.
     *
     * @param \AmazonS3
     * @param string $bucket
     */
    public function __construct($awsS3,$bucket)
    {
        $this->awsS3 = $awsS3;
        $this->awsS3->set_region($awsS3::REGION_APAC_NE1);
        $this->bucket = $bucket;
    }

    public function upload(ImageFile $imageFile,$uploadDir)
    {
        if(mb_substr($uploadDir,-1) !== '/') $uploadDir = $uploadDir.'/';
        $uploadPath = $uploadDir . $imageFile->getFileName();
        $response = $this->awsS3->createObject($this->bucket,$uploadPath,array(
            "fileUpload" => $imageFile->getFilePath(),
            "contentType" => $imageFile->getMimeType(),
        ));
        if(!$response->isOk()) throw new SystemErrorException('failedToUploadImage');
    }
}