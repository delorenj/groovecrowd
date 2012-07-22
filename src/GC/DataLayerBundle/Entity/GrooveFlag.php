<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\GrooveFlag
 *
 * @ORM\Table(name="groove_flag")
 * @ORM\Entity
 */
class GrooveFlag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var Groove
     *
     * @ORM\ManyToOne(targetEntity="Groove")
     */
    private $groove;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;


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
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set groove
     *
     * @param GC\DataLayerBundle\Entity\Groove $groove
     */
    public function setGroove(\GC\DataLayerBundle\Entity\Groove $groove)
    {
        $this->groove = $groove;
    }

    /**
     * Get groove
     *
     * @return GC\DataLayerBundle\Entity\Groove 
     */
    public function getGroove()
    {
        return $this->groove;
    }

    /**
     * Set user
     *
     * @param GC\DataLayerBundle\Entity\User $user
     */
    public function setUser(\GC\DataLayerBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return GC\DataLayerBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}