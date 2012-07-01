<?php

namespace GC\DataLayerBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var string $first_name
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $first_name;

    /**
     * @var string $last_name
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $last_name;

    /**
     * @var string $address1
     *
     * @ORM\Column(name="address1", type="string", length=255, nullable=true)
     */
    protected $address1;

    /**
     * @var string $address2
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    protected $address2;

    /**
     * @var string $city
     *
     * @ORM\Column(name="city", type="string", length=30, nullable=true)
     */
    protected $city;

    /**
     * @var string $state
     *
     * @ORM\Column(name="state", type="string", length=3, nullable=true)
     */
    protected $state;

    /**
     * @var string $zip
     *
     * @ORM\Column(name="zip", type="string", length=10, nullable=true)
     */
    protected $zip;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=true)
     */
    protected $phone;

  
    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @var integer $groove_sets
     *
     * @ORM\OneToMany(targetEntity="GrooveSet", mappedBy="user")
     */
    protected $groove_sets;

    /**
     * @var integer $watched_categories
     *
     * @ORM\OneToMany(targetEntity="WatchCategory", mappedBy="user")
     */
    protected $watched_categories;

    /**
     * @var integer $watched_projects
     *
     * @ORM\OneToMany(targetEntity="WatchProject", mappedBy="user")
     */
    protected $watched_projects;

    public function __construct()
    {
        parent::__construct();
        $this->groove_sets = new ArrayCollection();
        $this->watched_categories = new ArrayCollection();
        $this->watched_projects = new ArrayCollection();
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
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

    /**
     * Add watched_categories
     *
     * @param GC\DataLayerBundle\Entity\WatchCategory $watchedCategories
     */
    public function addWatchCategory(\GC\DataLayerBundle\Entity\WatchCategory $watchedCategories)
    {
        $this->watched_categories[] = $watchedCategories;
    }

    /**
     * Get watched_categories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWatchedCategories()
    {
        return $this->watched_categories;
    }

    /**
     * Add watched_projects
     *
     * @param GC\DataLayerBundle\Entity\WatchProject $watchedProjects
     */
    public function addWatchProject(\GC\DataLayerBundle\Entity\WatchProject $watchedProjects)
    {
        $this->watched_projects[] = $watchedProjects;
    }

    /**
     * Get watched_projects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWatchedProjects()
    {
        return $this->watched_projects;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set address1
     *
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    public function getLastInitial() {
    	return strtoupper(substr($this->last_name, 0, 1)) . ".";
    }

    public function toArray() {
        $a = array(
        	"id" => $this->getId(),
        	"username" => $this->getUsername(),
        	"first_name" => $this->getFirstName(),
        	"last_initial" => $this->getLastInitial(),
            "image" => $this->getImage());

       	return $a;
    }    
}