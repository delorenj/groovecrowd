<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\AssetType;
use GC\DataLayerBundle\Entity\GrooveType;
use GC\DataLayerBundle\Entity\Package;
use GC\DataLayerBundle\Entity\ProjectType;
use GC\DataLayerBundle\Entity\Tag;
use GC\DataLayerBundle\Helpers;

class LoadSimpleData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 1;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->asset("web");
        $this->asset("upload");        

        $this->groove("generic");
        $this->groove("midi");
        $this->groove("fx");
        $this->groove("synchronized");

        $this->package("Bronze");
        $this->package("Silver");
        $this->package("Gold");
        
        $this->projectType("Music");
        $this->projectType("Voice Over");
        $this->projectType("Audio FX");

        $this->tag("playful");
        $this->tag("video game");
        $this->tag("pizzacato");
        $this->tag("retro");
        $this->tag("old school");
        $this->tag("8-bit");
        $this->tag("industrial");
        $this->tag("female");
        $this->tag("trailer");
        $this->tag("sounds");
        $this->tag("effects");
        $this->tag("fx");
        $this->tag("score");
        $this->tag("bonus");
        $this->tag("level up");
    }

    private function asset($name) {
        $x = new AssetType();
        $x->setName($name);
        $this->addReference("asset-" . Helpers::slugify($name), $x);        
        $this->manager->persist($x);
        $this->manager->flush();
    } 
    private function groove($name) {
        $x = new GrooveType();
        $x->setName($name);
        $this->manager->persist($x);
        $this->manager->flush();
        $this->addReference("groove-" . Helpers::slugify($name), $x);

    }    

    private function package($name) {
        $x = new Package();
        $x->setName($name);
        $x->setSlug(Helpers::slugify($name));        
        $this->manager->persist($x);
        $this->manager->flush();
        $this->addReference("package-" . Helpers::slugify($name), $x);

    }    

    private function projectType($name) {
        $x = new ProjectType();
        $x->setName($name);
        $x->setSlug(Helpers::slugify($name));
        $this->manager->persist($x);
        $this->manager->flush();
        $this->addReference("project-type-" . Helpers::slugify($name), $x);

    }    
    private function tag($name) {
        $x = new Tag();
        $x->setCount(0);
        $x->setName($name);
        $x->setSlug(Helpers::slugify($name));        
        $this->addReference("tag-" . Helpers::slugify($name), $x);        
        $this->manager->persist($x);
        $this->manager->flush();
    }    
}