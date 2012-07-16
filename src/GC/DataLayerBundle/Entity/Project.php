<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use GC\DataLayerBundle\Entity\ProjectTag;
use GC\DataLayerBundle\Entity\Tag;

/**
 * GC\DataLayerBundle\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="GC\DataLayerBundle\Entity\ProjectRepository")     
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
     * @var Package
     *
     * @ORM\ManyToOne(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
     */
    private $package;

    /**
     * @var WinningGroove
     *
     * @ORM\ManyToOne(targetEntity="Groove")
     * @ORM\JoinColumn(name="winning_groove_id", referencedColumnName="id")
     */
    private $winningGroove;


    /**
     * @var ProjectType
     *
     * @ORM\ManyToOne(targetEntity="ProjectType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_type_id", referencedColumnName="id")
     * })
     */
    private $projectType;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer $payoutGuaranteed
     *
     * @ORM\Column(name="payout_guaranteed", type="boolean", nullable=true)
     */
    private $payoutGuaranteed;

    /**
     * @var integer $protection
     *
     * @ORM\Column(name="protection", type="boolean", nullable=true)
     */
    private $protection;

    /**
     * @var integer $contestLength
     *
     * @ORM\Column(name="contest_length", type="integer", nullable=true)
     */
    private $contestLength;

    /**
     * @var integer $enabled
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var integer $fullGrooveSetsOnly
     *
     * @ORM\Column(name="full_groove_sets_only", type="boolean", nullable=true)
     */
    private $fullGrooveSetsOnly;

    /**
     * @var integer $blind
     *
     * @ORM\Column(name="blind", type="boolean", nullable=true)
     */
    private $blind;

    /**
     * @var integer $flags
     *
     * @ORM\Column(name="flags", type="integer", nullable=true)
     */
    private $flags;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */

    private $createdAt;

    /**
     * @var datetime $expiresAt
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */

    private $expiresAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt;

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
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="projects")
     * @ORM\JoinTable(name="project_tag")
     **/
    protected $tags;

/**
     * @ORM\OneToMany(targetEntity="ProjectAsset", mappedBy="project")
     * @ORM\JoinTable(name="project_asset")
     **/
    protected $assets;

/**
     * @ORM\OneToMany(targetEntity="ProjectComment", mappedBy="project")
     * @ORM\JoinTable(name="project_comment")
     **/
    protected $comments;


    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->assets = new ArrayCollection();
        $this->comments = new ArrayCollection();

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
     * Get enabled
     *
     * @return integer 
     */
    public function isEnabled()
    {
        return $this->enabled;
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

    /**
     * Set fullGrooveSetsOnly
     *
     * @param integer $fullGrooveSetsOnly
     */
    public function setFullGrooveSetsOnly($fullGrooveSetsOnly)
    {
        $this->fullGrooveSetsOnly = $fullGrooveSetsOnly;
    }

    /**
     * Get fullGrooveSetsOnly
     *
     * @return integer 
     */
    public function getFullGrooveSetsOnly()
    {
        return $this->fullGrooveSetsOnly;
    }

    /**
     * Set package
     *
     * @param GC\DataLayerBundle\Entity\Package $package
     */
    public function setPackage(\GC\DataLayerBundle\Entity\Package $package)
    {
        $this->package = $package;
    }

    /**
     * Get package
     *
     * @return GC\DataLayerBundle\Entity\Package 
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set projectType
     *
     * @param GC\DataLayerBundle\Entity\ProjectType $projectType
     */
    public function setProjectType(\GC\DataLayerBundle\Entity\ProjectType $projectType)
    {
        $this->projectType = $projectType;
    }

    /**
     * Get projectType
     *
     * @return GC\DataLayerBundle\Entity\ProjectType 
     */
    public function getProjectType()
    {
        return $this->projectType;
    }


    /**
     * Add tags
     *
     * @param GC\DataLayerBundle\Entity\Tag $tag
     */
    public function addTag(\GC\DataLayerBundle\Entity\Tag $tag)
    {
        if (!$this->tags->exists(function($key, $val) use($tag) {
                                    $check = false;
                                    if ($val === $tag)
                                        $check = true;
                                    return $check;
                                })
            ) {
            $this->tags->add($tag);            
        }       
        $tag->addProject($this);
    }

    public function removeTag(\GC\DataLayerBundle\Entity\Tag $tag)
    {
        if ($this->tags->exists(function($key, $val) use($tag) {
                                    $check = false;
                                    if ($val === $tag)
                                        $check = true;
                                    return $check;
                                })
            ) {
            $this->tags->delete($tag);            
        }       
        $tag->removeProject($this);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function hasTag($name) {
        return in_array($name, $this->tags);
    }

    /**
     * Set contestLength
     *
     * @param integer $contestLength
     */
    public function setContestLength($contestLength)
    {
        $this->contestLength = $contestLength;
    }

    /**
     * Get contestLength
     *
     * @return integer 
     */
    public function getContestLength()
    {
        return $this->contestLength;
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
     * Set protection
     *
     * @param boolean $protection
     */
    public function setProtection($protection)
    {
        $this->protection = $protection;
    }

    /**
     * Get protection
     *
     * @return boolean 
     */
    public function getProtection()
    {
        return $this->protection;
    }

    /**
     * Add assets
     *
     * @param GC\DataLayerBundle\Entity\ProjectAsset $assets
     */
    public function addProjectAsset(\GC\DataLayerBundle\Entity\ProjectAsset $assets)
    {
        $this->assets[] = $assets;
    }

    /**
     * Get assets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAssets()
    {
        return $this->assets;
    }

    public function toArray() {
        $a = array(
        	"id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "organizaion" => $this->organization,
            "payoutGuaranteed" => $this->payoutGuaranteed,
            "protection" => $this->protection,
            "contestLength" => $this->contestLength,
            "enabled" => $this->enabled,
            "fullGrooveSetsOnly" => $this->fullGrooveSetsOnly,
            "blind" => $this->blind,
            "flags" => $this->flags,
            "projectType" => $this->projectType->getName(),
            "createdAt" => $this->createdAt,
            "modifiedAt" => $this->modifiedAt,
            "winningGroove" => $this->winningGroove == null ? null : $this->winningGroove->toArray(),
            "category" => $this->category->toArray());

        $tags = array();
        foreach($this->tags as $x) {
            $tags[] = $x->getName();
        }
        $a["tags"] = $tags;

        $assets = array();
        foreach($this->assets as $x) {
            $assets[] = $x->toArray();
        }
        $a["assets"] = $assets;

        $comments = array();
        foreach($this->comments as $x) {
            $comments[] = $x->toArray();
        }
        $a["comments"] = $comments;
        return $a;
    }

    /**
     * Add comments
     *
     * @param GC\DataLayerBundle\Entity\ProjectComment $comments
     */
    public function addProjectComment(\GC\DataLayerBundle\Entity\ProjectComment $comments)
    {
        $this->comments[] = $comments;
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set winningGroove
     *
     * @param GC\DataLayerBundle\Entity\Groove $winningGroove
     */
    public function setWinningGroove(\GC\DataLayerBundle\Entity\Groove $winningGroove)
    {
        $this->winningGroove = $winningGroove;
    }

    /**
     * Get winningGroove
     *
     * @return GC\DataLayerBundle\Entity\Groove 
     */
    public function getWinningGroove()
    {
        return $this->winningGroove;
    }
}