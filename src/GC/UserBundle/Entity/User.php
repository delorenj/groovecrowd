<?php

namespace GC\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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

    public function __construct()
    {
        parent::__construct();
        // init stuff
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}