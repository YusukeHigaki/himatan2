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
     * @ORM\Column(name="from_user_id", type="integer", nullable=false)
     * @Assert\NotBlank(groups={"set_like_api"})
     * @Assert\Type(type="integer",groups={"set_like_api"})
     */
    private $fromUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="to_user_id", type="integer", nullable=false)
     * @Assert\NotBlank(groups={"set_like_api"})
     * @Assert\Type(type="integer",groups={"set_like_api"})
     */
    private $toUserId;

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

    /**
     * Set fromUserId
     *
     * @param integer $fromUserId
     * @return UserLike
     */
    public function setFromUserId($fromUserId)
    {
        $this->fromUserId = $fromUserId;

        return $this;
    }

    /**
     * Get fromUserId
     *
     * @return integer 
     */
    public function getFromUserId()
    {
        return $this->fromUserId;
    }

    /**
     * Set toUserId
     *
     * @param integer $toUserId
     * @return UserLike
     */
    public function setToUserId($toUserId)
    {
        $this->toUserId = $toUserId;

        return $this;
    }

    /**
     * Get toUserId
     *
     * @return integer 
     */
    public function getToUserId()
    {
        return $this->toUserId;
    }
}
