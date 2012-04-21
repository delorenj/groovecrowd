<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\AssetType;
use GC\DataLayerBundle\Entity\GrooveType;
use GC\DataLayerBundle\Entity\Industry;
use GC\DataLayerBundle\Entity\Tag;

class LoadSimpleData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 1;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->add("AssetType", "image");
        $this->add("AssetType", "video");
        $this->add("AssetType", "audio");
    }


    private function add($table, $name) {
        $x = new AssetType();
        $x->setName($name);
        $this->manager->persist($x);
        $this->manager->flush();
    }    
}