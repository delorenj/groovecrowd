<?php

namespace GC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GC\ProjectBundle\Entity;

/**
 * GC\UserBundle\Entity\WatchProject
 *
 * @ORM\Table(name="watch_project")
 * @ORM\Entity
 */
class WatchProject
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
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * })
     */
    private $project;

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
     * @param GC\ProjectBundle\Entity\Project $project
     */
    public function setProject(\GC\ProjectBundle\Entity\Project $project)
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

    /**
     * Set user
     *
     * @param GC\UserBundle\Entity\User $user
     */
    public function setUser(\GC\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return GC\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}