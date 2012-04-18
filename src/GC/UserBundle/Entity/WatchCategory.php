<?php

namespace GC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\UserBundle\Entity\WatchCategory
 *
 * @ORM\Table(name="watch_category")
 * @ORM\Entity
 */
class WatchCategory
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

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
     * Set category
     *
     * @param GC\ProjectBundle\Entity\Category $category
     */
    public function setCategory(\GC\ProjectBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return GC\ProjectBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
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