<?php

namespace Yusuke\HimatanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * UserArea
 * @ORM\Entity(repositoryClass="Yusuke\HimatanBundle\Entity\Repository\UserAreaRepository")
 * @ORM\Table(name="user_area")
 */
class UserArea
{
    /**
     * @var /UserPost
     *
     * @ORM\ManyToOne(targetEntity="UserPost")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    /**
     * @var integer
     *
     * @ORM\Column(name="area_id", type="integer", nullable=false)
     */
    private $areaId;

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
     * Set areaId
     *
     * @param integer $areaId
     * @return UserArea
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;

        return $this;
    }

    /**
     * Get areaId
     *
     * @return integer 
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserArea
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
     * @return UserArea
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
     * @return UserArea
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
     * Get post
     *
     * @return /Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set post
     *
     * @param integer $post
     * @return UserArea
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }
}
