<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/30
 * Time: 13:33
 */
namespace Yusuke\HimatanBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Yusuke\HimatanBundle\Entity\UserPost;
use Yusuke\HimatanBundle\Entity\UserArea;
use Yusuke\HimatanBundle\Entity\UserImg;

class PostService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function selectPosts($limit, $postId = NULL)
    {
        if (!$postId){
            $q = $this->em->getRepository('YusukeHimatanBundle:UserPost')->createQueryBuilder('p')
                ->where('p.deleteFlag = 0')
                ->orderBy('p.id', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
            ;
        }else{
            $q = $this->em->getRepository('YusukeHimatanBundle:UserPost')->createQueryBuilder('p')
                ->where('p.deleteFlag = 0')
                ->andWhere('p.id < :postId')
                ->setParameter('postId', $postId)
                ->orderBy('p.id', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
            ;
        }
        $posts = $q->getResult();

        for ($i = 0; $i < count($posts); $i++){

            $img = $this->em->getRepository('YusukeHimatanBundle:UserImg')->findOneBy(array(
                'user' => $posts[$i]->getUser()->getId()
            ));
            $posts[$i]->getUser()->setImg($img);
        }
        return $posts;
    }

}
