<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\GrooveSlot
 *
 * @ORM\Table(name="groove_slot")
 * @ORM\Entity
 */
class GrooveSlot
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * })
     */
    private $project;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer $min_length_in_milliseconds
     *
     * @ORM\Column(name="min_length_in_milliseconds", type="integer")
     */
    private $min_length_in_milliseconds;

    /**
     * @var integer $payout_amount
     *
     * @ORM\Column(name="payout_amount", type="integer")
     */
    private $payout_amount;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt;

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
     * Set project
     *
     * @param GC\DataLayerBundle\Entity\Project $project
     */
    public function setProject(\GC\DataLayerBundle\Entity\Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return GC\DataLayerBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set min_length_in_milliseconds
     *
     * @param integer $minLengthInMilliseconds
     */
    public function setMinLengthInMilliseconds($minLengthInMilliseconds)
    {
        $this->min_length_in_milliseconds = $minLengthInMilliseconds;
    }

    /**
     * Get min_length_in_milliseconds
     *
     * @return integer 
     */
    public function getMinLengthInMilliseconds()
    {
        return $this->min_length_in_milliseconds;
    }

    /**
     * Set payout_amount
     *
     * @param integer $payoutAmount
     */
    public function setPayoutAmount($payoutAmount)
    {
        $this->payout_amount = $payoutAmount;
    }

    /**
     * Get payout_amount
     *
     * @return integer 
     */
    public function getPayoutAmount()
    {
        return $this->payout_amount;
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

}