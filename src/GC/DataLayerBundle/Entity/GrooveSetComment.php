<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GC\DataLayerBundle\Entity\GrooveSetComment
 *
 * @ORM\Table(name="groove_set_comment")
 * @ORM\Entity
 */
class GrooveSetComment
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
     * @var text $body
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @var GrooveSet
     *
     * @ORM\ManyToOne(targetEntity="GrooveSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groove_set_id", referencedColumnName="id")
     * })
     */
    private $grooveSet;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}