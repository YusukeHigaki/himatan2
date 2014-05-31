<?php

namespace Yusuke\HimatanBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Yusuke\HimatanBundle\Entity\User;
use Symfony\Component\Validator\Validator;
use Yusuke\HimatanBundle\Exception\ClientErrorException;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function selectUser($id)
    {
        $user = $this->findOneBy(array(
            'id' => $id,
            'deleteFlag' => 0
        ));
        return $user;
    }

    public function setUser(User $user)
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
        return $user;
    }
}
