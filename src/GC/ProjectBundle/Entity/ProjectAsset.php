<?php

namespace GC\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\ProjectBundle\Entity\ProjectAsset
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
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * })
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
     * @param GC\ProjectBundle\Entity\AssetType $assetType
     */
    public function setAssetType(\GC\ProjectBundle\Entity\AssetType $assetType)
    {
        $this->assetType = $assetType;
    }

    /**
     * Get assetType
     *
     * @return GC\ProjectBundle\Entity\AssetType 
     */
    public function getAssetType()
    {
        return $this->assetType;
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
}