<?php

namespace GC\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\ProjectBundle\Entity\ProjectTag
 *
 * @ORM\Table(name="project_tag")
 * @ORM\Entity
 */
class ProjectTag
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
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tag
     *
     * @param GC\ProjectBundle\Entity\Tag $tag
     */
    public function setTag(\GC\UserBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return GC\ProjectBundle\Entity\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set project
     *
     * @param GC\ProjectBundle\Entity\Project $project
     */
    public function setProject(\GC\UserBundle\Entity\Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return GC\ProjectBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
}