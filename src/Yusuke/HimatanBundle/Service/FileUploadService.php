<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/27
 * Time: 11:51
 */
namespace Yusuke\HimatanBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validation;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Component\ImageFile;
use Yusuke\HimatanBundle\Entity\UserImg;

class FileUploadService
{
    private $managerRegistry;
    private $imageFile;
    private $s3UploadService;
    private $container;

    public function __construct(
        RegistryInterface $managerRegistry,
        ImageFile $imageFile,
        S3uploadService $s3_upload_service,
        ContainerInterface $container
    ){
        $this->managerRegistry = $managerRegistry;
        $this->imageFile = $imageFile;
        $this->container = $container;
        $this->s3UploadService = $s3_upload_service;
    }

    public function upload($file, $number, $userId)
    {
        $this->imageFile->set($file);
        $img = $this->imageFile;

        $dir = $this->container->getParameter('amazon_s3_dir').'user/';
        $this->s3UploadService->upload($img, $dir);
        $img->remove();
        $this->validate($img->getFileName(), $number, $userId);
        $this->updateUserImg($img->getFileName(), $number, $userId);
    }

    public function validate($fileName, $number, $userId)
    {
        $userImg = new UserImg();
        $userImg
            ->setUserId($userId)
            ->setImg($fileName)
            ->setNumber($number)
        ;
        $errors = $this->container->get('validator')->validate($userImg, array('file_upload_service'));
        if (count($errors) > 0) throw new ClientErrorException('invalidPostValue1');
    }

    public function updateUserImg($fileName, $number, $userId)
    {
        $userImgRepository = $this->managerRegistry->getRepository('YusukeHimatanBundle:UserImg');
        $em = $this->managerRegistry->getEntityManager();

        $exUserImg = $userImgRepository->findOneBy(array(
            'userId' => $userId,
            'number' => $number,
            'deleteFlag' => 0
        ));
        if ($exUserImg){
            $exUserImg->setDeleteFlag(1);
            $em->persist($exUserImg);
        }

        $userImg = new UserImg();
        $userImg
            ->setImg($fileName)
            ->setNumber($number)
            ->setUserId($userId)
        ;
        $em->persist($userImg);
        $em->flush();
    }

}