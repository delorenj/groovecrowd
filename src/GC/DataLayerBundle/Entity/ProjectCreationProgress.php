<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\ProjectCreationProgress
 *
 * @ORM\Table(name="project_creation_progress")
 * @ORM\Entity
 */
class ProjectCreationProgress
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
     * @var integer $project
     *
     * @ORM\OneToOne(targetEntity="Project")
     */
    private $project;

    /**
     * @var integer $phase
     * @ORM\Column(name="phase", type="integer", nullable=false)
     */
    private $phase;


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
     * Set phase
     *
     * @param integer $phase
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
    }

    /**
     * Get phase
     *
     * @return integer 
     */
    public function getPhase()
    {
        return $this->phase;
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
}