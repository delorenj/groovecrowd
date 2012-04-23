<?php

namespace GC\DataLayerBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use GC\DataLayerBundle\Entity\GrooveSet;

/**
 * GC\DataLayerBundle\Entity\User
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="GC\DataLayerBundle\Entity\UserRepository") 
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    // /**
    //  * @ORM\Column(type="array", name="roles")
    //  */
    // protected $roles;

    /**
     * @var string $image_path
     *
     * @ORM\Column(name="image_path", type="string", length=255, nullable=true)
     */
    protected $image_path;

    /**
     * @var integer $groove_sets
     *
     * @ORM\OneToMany(targetEntity="GrooveSet", mappedBy="user")
     */
    protected $groove_sets;


    public function __construct()
    {
        parent::__construct();
        $this->groove_sets = new ArrayCollection();
    }

    /**
     * Set image_path
     *
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->image_path = $imagePath;
    }

    /**
     * Get image_path
     *
     * @return string 
     */
    public function getImagePath()
    {
        return $this->image_path;
    }

    /**
     * Get groove_sets
     *
     * @return GC\DataLayerBundle\Entity\GrooveSet
     */
    public function getGrooveSets()
    {
        return $this->groove_sets;
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
     * Add groove_sets
     *
     * @param GC\DataLayerBundle\Entity\GrooveSet $grooveSets
     */
    public function addGrooveSet(\GC\DataLayerBundle\Entity\GrooveSet $grooveSets)
    {
        $this->groove_sets[] = $grooveSets;
    }
}