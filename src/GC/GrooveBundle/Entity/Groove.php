<?php

namespace GC\GrooveBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\GrooveBundle\Entity\Groove
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
     * @var smallint $rating
     *
     * @ORM\Column(name="rating", type="smallint", nullable=false)
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
     * @var GrooveSet
     *
     * @ORM\ManyToOne(targetEntity="GrooveSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groove_set_id", referencedColumnName="id")
     * })
     */
    private $grooveSet;



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
     * @param GC\GrooveBundle\Entity\GrooveType $grooveType
     */
    public function setGrooveType(\GC\GrooveBundle\Entity\GrooveType $grooveType)
    {
        $this->grooveType = $grooveType;
    }

    /**
     * Get grooveType
     *
     * @return GC\GrooveBundle\Entity\GrooveType 
     */
    public function getGrooveType()
    {
        return $this->grooveType;
    }

    /**
     * Set grooveSet
     *
     * @param GC\GrooveBundle\Entity\GrooveSet $grooveSet
     */
    public function setGrooveSet(\GC\GrooveBundle\Entity\GrooveSet $grooveSet)
    {
        $this->grooveSet = $grooveSet;
    }

    /**
     * Get grooveSet
     *
     * @return GC\GrooveBundle\Entity\GrooveSet 
     */
    public function getGrooveSet()
    {
        return $this->grooveSet;
    }
}