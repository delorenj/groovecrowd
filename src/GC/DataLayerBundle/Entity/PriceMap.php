<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\PriceMap
 *
 * @ORM\Table(name="price_map")
 * @ORM\Entity
 */
class PriceMap
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
     * @var integer $project_type_id
     *
     * @ORM\Column(name="project_type_id", type="integer", nullable=false)
     */
    private $project_type_id;

    /**
     * @var integer package_id
     *
     * @ORM\Column(name="package_id", type="integer", nullable=false)
     */
    private $package_id;


    /**
     * @var integer $payout
     *
     * @ORM\Column(name="payout", type="integer", nullable=false)
     */
    private $payout;

    /**
     * @var integer $price
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;
    


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
     * Set project_type_id
     *
     * @param integer $projectTypeId
     */
    public function setProjectTypeId($projectTypeId)
    {
        $this->project_type_id = $projectTypeId;
    }

    /**
     * Get project_type_id
     *
     * @return integer 
     */
    public function getProjectTypeId()
    {
        return $this->project_type_id;
    }

    /**
     * Set package_id
     *
     * @param integer $packageId
     */
    public function setPackageId($packageId)
    {
        $this->package_id = $packageId;
    }

    /**
     * Get package_id
     *
     * @return integer 
     */
    public function getPackageId()
    {
        return $this->package_id;
    }

    /**
     * Set payout
     *
     * @param integer $payout
     */
    public function setPayout($payout)
    {
        $this->payout = $payout;
    }

    /**
     * Get payout
     *
     * @return integer 
     */
    public function getPayout()
    {
        return $this->payout;
    }

    /**
     * Set price
     *
     * @param integer $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }
}