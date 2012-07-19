<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\Groove
 *
 * @ORM\Table(name="groove")
 * @ORM\Entity
 */
class Groove
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
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $uri
     *
     * @ORM\Column(name="uri", type="string", length=255, nullable=false)
     */
    private $uri;

    /**
     * @var smallint $rating
     *
     * @ORM\Column(name="rating", type="smallint", nullable=true)
     */
    private $rating;

    /**
     * @var integer $lengthInMilliseconds
     *
     * @ORM\Column(name="length_in_milliseconds", type="integer", nullable=false)
     */
    private $lengthInMilliseconds;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var GrooveType
     *
     * @ORM\ManyToOne(targetEntity="GrooveType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groove_type_id", referencedColumnName="id")
     * })
     */
    private $grooveType;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="grooves")
     * @ORM\JoinTable(name="groove_tag")
     **/
    protected $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * Set uri
     *
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }
    
    /**
     * Set rating
     *
     * @param smallint $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get rating
     *
     * @return smallint 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set lengthInMilliseconds
     *
     * @param integer $lengthInMilliseconds
     */
    public function setLengthInMilliseconds($lengthInMilliseconds)
    {
        $this->lengthInMilliseconds = $lengthInMilliseconds;
    }

    /**
     * Get lengthInMilliseconds
     *
     * @return integer 
     */
    public function getLengthInMilliseconds()
    {
        return $this->lengthInMilliseconds;
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
     * Set grooveType
     *
     * @param GC\DataLayerBundle\Entity\GrooveType $grooveType
     */
    public function setGrooveType(\GC\DataLayerBundle\Entity\GrooveType $grooveType)
    {
        $this->grooveType = $grooveType;
    }

    /**
     * Get grooveType
     *
     * @return GC\DataLayerBundle\Entity\GrooveType 
     */
    public function getGrooveType()
    {
        return $this->grooveType;
    }
 
    /**
     * Add tags
     *
     * @param GC\DataLayerBundle\Entity\Tag $tags
     */
    public function addTag(\GC\DataLayerBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
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

    public function toArray() {
        $a = array(
            "id" => $this->id,
            "user" => $this->getUser()->toArray(),
            "title" => $this->getTitle(),
            "description" => $this->getDescription(),
            "rating" => $this->getRating(),
            "uri" => $this->getUri(),
            "lengthInMilliseconds" => $this->getLengthInMilliseconds(),
            "lengthFormatted" => $this->getLengthFormatted(),
            "grooveType" => $this->getGrooveType()->getName(),
            "createdAt" => $this->getCreatedAt());

            $tags = array();
            foreach($this->tags as $x) {
                $tags[] = $x->getName();
            }
            $a["tags"] = $tags;

        return $a;
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

    private function getLengthFormatted() {
        $seconds = floor($this->getLengthInMilliseconds()/1000);
        return gmdate("i:s", $seconds);
    }
}