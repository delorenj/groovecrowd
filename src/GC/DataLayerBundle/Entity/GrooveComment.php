<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\GrooveComment
 *
 * @ORM\Table(name="groove_comment")
 * @ORM\Entity
 */
class GrooveComment
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
     * @var text $body
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @var Groove
     *
     * @ORM\ManyToOne(targetEntity="Groove")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groove_id", referencedColumnName="id")
     * })
     */
    private $groove;

    /**
     * @var FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
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
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
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
     * Set modifiedAt
     *
     * @param datetime $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * Get modifiedAt
     *
     * @return datetime 
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
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
     * @param GC\DataLayerBundle\Entity\FosUser $user
     */
    public function setUser(\GC\DataLayerBundle\Entity\FosUser $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return GC\DataLayerBundle\Entity\FosUser 
     */
    public function getUser()
    {
        return $this->user;
    }
}