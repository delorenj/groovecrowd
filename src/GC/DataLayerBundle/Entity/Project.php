<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string $organization
     *
     * @ORM\Column(name="organization", type="string", length=255, nullable=true)
     */
    private $organization;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var integer $payoutAmount
     *
     * @ORM\Column(name="payout_amount", type="integer", nullable=false)
     */
    private $payoutAmount;

    /**
     * @var integer $payoutGuaranteed
     *
     * @ORM\Column(name="payout_guaranteed", type="integer", nullable=false)
     */
    private $payoutGuaranteed;

    /**
     * @var datetime $expiresAt
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=false)
     */
    private $expiresAt;

    /**
     * @var integer $enabled
     *
     * @ORM\Column(name="enabled", type="integer", nullable=false)
     */
    private $enabled;

    /**
     * @var integer $winningGrooveSetId
     *
     * @ORM\Column(name="winning_groove_set_id", type="integer", nullable=true)
     */
    private $winningGrooveSetId;

    /**
     * @var integer $blind
     *
     * @ORM\Column(name="blind", type="integer", nullable=false)
     */
    private $blind;

    /**
     * @var integer $flags
     *
     * @ORM\Column(name="flags", type="integer", nullable=false)
     */
    private $flags;

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
     * @var Industry
     *
     * @ORM\ManyToOne(targetEntity="Industry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="industry_id", referencedColumnName="id")
     * })
     */
    private $industry;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;



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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set organization
     *
     * @param string $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get organization
     *
     * @return string 
     */
    public function getOrganization()
    {
        return $this->organization;
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
     * Set payoutAmount
     *
     * @param integer $payoutAmount
     */
    public function setPayoutAmount($payoutAmount)
    {
        $this->payoutAmount = $payoutAmount;
    }

    /**
     * Get payoutAmount
     *
     * @return integer 
     */
    public function getPayoutAmount()
    {
        return $this->payoutAmount;
    }

    /**
     * Set payoutGuaranteed
     *
     * @param integer $payoutGuaranteed
     */
    public function setPayoutGuaranteed($payoutGuaranteed)
    {
        $this->payoutGuaranteed = $payoutGuaranteed;
    }

    /**
     * Get payoutGuaranteed
     *
     * @return integer 
     */
    public function getPayoutGuaranteed()
    {
        return $this->payoutGuaranteed;
    }

    /**
     * Set expiresAt
     *
     * @param datetime $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Get expiresAt
     *
     * @return datetime 
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return integer 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set winningGrooveSetId
     *
     * @param integer $winningGrooveSetId
     */
    public function setWinningGrooveSetId($winningGrooveSetId)
    {
        $this->winningGrooveSetId = $winningGrooveSetId;
    }

    /**
     * Get winningGrooveSetId
     *
     * @return integer 
     */
    public function getWinningGrooveSetId()
    {
        return $this->winningGrooveSetId;
    }

    /**
     * Set blind
     *
     * @param integer $blind
     */
    public function setBlind($blind)
    {
        $this->blind = $blind;
    }

    /**
     * Get blind
     *
     * @return integer 
     */
    public function getBlind()
    {
        return $this->blind;
    }

    /**
     * Set flags
     *
     * @param integer $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    /**
     * Get flags
     *
     * @return integer 
     */
    public function getFlags()
    {
        return $this->flags;
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
     * Set industry
     *
     * @param GC\DataLayerBundle\Entity\Industry $industry
     */
    public function setIndustry(\GC\DataLayerBundle\Entity\Industry $industry)
    {
        $this->industry = $industry;
    }

    /**
     * Get industry
     *
     * @return GC\DataLayerBundle\Entity\Industry 
     */
    public function getIndustry()
    {
        return $this->industry;
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

    /**
     * Set category
     *
     * @param GC\DataLayerBundle\Entity\Category $category
     */
    public function setCategory(\GC\DataLayerBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return GC\DataLayerBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}