<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\GrooveSlotTag
 *
 * @ORM\Table(name="groove_slot_tag")
 * @ORM\Entity
 */
class GrooveSlotTag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @var GrooveSlot
     *
     * @ORM\ManyToOne(targetEntity="GrooveSlot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groove_slot_id", referencedColumnName="id")
     * })
     */
    private $grooveSlot;


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
     * @param GC\DataLayerBundle\Entity\Tag $tag
     */
    public function setTag(\GC\DataLayerBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return GC\DataLayerBundle\Entity\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set grooveSlot
     *
     * @param GC\DataLayerBundle\Entity\GrooveSlot $grooveSlot
     */
    public function setGrooveSlot(\GC\DataLayerBundle\Entity\GrooveSlot $grooveSlot)
    {
        $this->grooveSlot = $grooveSlot;
    }

    /**
     * Get grooveSlot
     *
     * @return GC\DataLayerBundle\Entity\GrooveSlot 
     */
    public function getGrooveSlot()
    {
        return $this->grooveSlot;
    }
}