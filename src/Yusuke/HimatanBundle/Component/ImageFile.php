<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/27
 * Time: 11:58
 */
namespace Yusuke\HimatanBundle\Component;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Yusuke\HimatanBundle\Exception\ClientErrorException;

/**
 * ImageFile.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 */
class ImageFile
{
    private $uploadedFile;

    private $filePath;

    private $fileName;

    private $mimeType;

    private $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function set(File $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
        if ($this->uploadedFile->getMimeType() !== 'image/jpeg') throw new ClientErrorException('invalidFileType');
        $this->generateFileName();
        $this->setFilePath();
        $this->uploadedFile->move($this->getUploadRootDir(),$this->fileName);
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getMimeType()
    {
        if($this->mimeType) return $this->mimeType;
        return $this->uploadedFile->getClientMimeType();
    }

    public function generateFileName($suffix = '')
    {
        list($usec, $sec) = explode(" ", microtime());
        $datenum = sprintf("%s", (string)$sec . ((string)$usec * 1000000));
        $extension = '.jpg';
        $this->fileName = $datenum . "_" . rand(1000, 9999) . $suffix . $extension;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFilePath()
    {
        $this->filePath = $this->getUploadRootDir() . '/' . $this->fileName;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    protected function getUploadRootDir()
    {
        return $this->container->get('kernel')->getRootDir() . '/../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'tmp/uploads';
    }

    public function remove()
    {
        unlink($this->filePath);
    }

}