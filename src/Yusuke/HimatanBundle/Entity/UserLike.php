<?php

namespace Yusuke\HimatanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * UserLike
 * @ORM\Entity(repositoryClass="Yusuke\HimatanBundle\Entity\Repository\UserLikeRepository")
 * @ORM\Table(name="user_like", indexes={@ORM\Index(name="like_to_user_idx", columns={"to_user"})})
 */
class UserLike
{
    /**
     * @var integer
     *
     * @ORM\Column(name="from_user", type="integer", nullable=false)
     */
    private $fromUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="to_user", type="integer", nullable=false)
     */
    private $toUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="delete_flag", type="integer")
     */
    private $deleteFlag = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set fromUser
     *
     * @param integer $fromUser
     * @return UserLike
     */
    public function setFromUser($fromUser)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * Get fromUser
     *
     * @return integer 
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set toUser
     *
     * @param integer $toUser
     * @return UserLike
     */
    public function setToUser($toUser)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get toUser
     *
     * @return integer 
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserLike
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return UserLike
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deleteFlag
     *
     * @param boolean $deleteFlag
     * @return UserLike
     */
    public function setDeleteFlag($deleteFlag)
    {
        $this->deleteFlag = $deleteFlag;

        return $this;
    }

    /**
     * Get deleteFlag
     *
     * @return boolean 
     */
    public function getDeleteFlag()
    {
        return $this->deleteFlag;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
