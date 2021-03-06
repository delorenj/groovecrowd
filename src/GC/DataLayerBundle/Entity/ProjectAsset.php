<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\ProjectAsset
 *
 * @ORM\Table(name="project_asset")
 * @ORM\Entity
 */
class ProjectAsset
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
     * @var string $uri
     *
     * @ORM\Column(name="uri", type="string", length=255, nullable=true)
     */
    private $uri;

    /**
     * @var string $thumbUri
     *
     * @ORM\Column(name="thumb_uri", type="string", length=255, nullable=true)
     */
    private $thumbUri;

    /**
     * @var text $caption
     *
     * @ORM\Column(name="caption", type="text", nullable=true)
     */
    private $caption;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var AssetType
     *
     * @ORM\ManyToOne(targetEntity="AssetType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_type_id", referencedColumnName="id")
     * })
     */
    private $assetType;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;



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
     * Set uri
     *
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set caption
     *
     * @param text $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * Get caption
     *
     * @return text 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set assetType
     *
     * @param GC\DataLayerBundle\Entity\AssetType $assetType
     */
    public function setAssetType(\GC\DataLayerBundle\Entity\AssetType $assetType)
    {
        $this->assetType = $assetType;
    }

    /**
     * Get assetType
     *
     * @return GC\DataLayerBundle\Entity\AssetType 
     */
    public function getAssetType()
    {
        return $this->assetType;
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

    /**
     * Set thumbUri
     *
     * @param string $thumbUri
     */
    public function setThumbUri($thumbUri)
    {
        $this->thumbUri = $thumbUri;
    }

    /**
     * Get thumbUri
     *
     * @return string 
     */
    public function getThumbUri()
    {
        return $this->thumbUri;
    }

    public function toArray() {
        return array(
            "id" => $this->id,
            "uri" => $this->uri,
            "thumbUri" => $this->thumbUri,
            "caption" => $this->caption,
            "createdAt" => $this->createdAt,
            "assetType" => $this->assetType->getName());
    }
}