<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity
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
     * @var integer $count
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;



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
}