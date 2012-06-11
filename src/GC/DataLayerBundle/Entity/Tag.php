<?php

namespace GC\DataLayerBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GC\DataLayerBundle\Helpers;

/**
 * GC\DataLayerBundle\Entity\Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="GC\DataLayerBundle\Entity\TagRepository")  
 * @ORM\HasLifecycleCallbacks() 
 */
class Tag
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=40, nullable=false)
     */
    private $slug;


    /**
     * @var integer $count
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;


    /**
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="tags")
     **/
    private $projects;

    /**
     * @ORM\ManyToMany(targetEntity="GrooveSlot", mappedBy="grooveSlots")
     **/
    private $grooveSlots;


    /**
     * @ORM\ManyToMany(targetEntity="Groove", mappedBy="grooves")
     **/
    private $grooves;

    public function __construct() {
        $this->projects = new ArrayCollection();
        $this->grooveSlots = new ArrayCollection();
        $this->grooves = new ArrayCollection();

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->slug = Helpers::slugify($name);
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set count
     *
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }


    // /**
    //  * @ORM\PostPersist
    //  */
    // public function updateTagCount()
    // {
    //     $tag = $this->getDoctrine()->getRepository('GCDataLayerBundle:Tag')->find($this->tagId);
    //     $tag->setCount($tag->getCount() + 1);
    // }

    /**
     * Add projects
     *
     * @param GC\DataLayerBundle\Entity\Project $project
     */
    public function addProject(\GC\DataLayerBundle\Entity\Project $project)
    {
        $this->projects[] = $project;
    }

    public function removeProject(\GC\DataLayerBundle\Entity\Project $project)
    {
        if ($this->projects->exists(function($key, $val) use($project) {
                                    $check = false;
                                    if ($val === $project)
                                        $check = true;
                                    return $check;
                                })
            ) {
            $this->projects->delete($project);            
        }       
    }

    /**
     * Get projects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add grooveSlots
     *
     * @param GC\DataLayerBundle\Entity\GrooveSlot $grooveSlots
     */
    public function addGrooveSlot(\GC\DataLayerBundle\Entity\GrooveSlot $grooveSlots)
    {
        $this->grooveSlots[] = $grooveSlots;
    }

    /**
     * Get grooveSlots
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGrooveSlots()
    {
        return $this->grooveSlots;
    }

    /**
     * Add grooves
     *
     * @param GC\DataLayerBundle\Entity\Groove $grooves
     */
    public function addGroove(\GC\DataLayerBundle\Entity\Groove $grooves)
    {
        $this->grooves[] = $grooves;
    }

    /**
     * Get grooves
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGrooves()
    {
        return $this->grooves;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function toArray() {
        return array(
            "name" => $this->name);
    }
}