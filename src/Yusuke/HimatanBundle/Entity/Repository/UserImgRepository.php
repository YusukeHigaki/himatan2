<?php

namespace Yusuke\HimatanBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserImgRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserImgRepository extends EntityRepository
{
    public function selectUserImg($id)
    {
        $userImg = $this->findBy(array(
            'userId' => $id,
            'deleteFlag' => 0,
        ));
        return $userImg;
    }
}

