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
        $this->asset("image");
        $this->asset("video");
        $this->asset("audio");

        $this->groove("generic");
        $this->groove("midi");
        $this->groove("fx");
        $this->groove("synchronized");

        $this->industry("Film");
        $this->industry("Commercial - TV");
        $this->industry("Commercial - Internet");
        $this->industry("Video Games");

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

    private function industry($name) {
        $x = new Industry();
        $x->setName($name);
        $this->manager->persist($x);
        $this->manager->flush();
        $this->addReference("industry-" . Helpers::slugify($name), $x);
    }    


    private function tag($name) {
        $x = new Tag();
        $x->setCount(0);
        $x->setName($name);
        $this->addReference("tag-" . Helpers::slugify($name), $x);        
        $this->manager->persist($x);
        $this->manager->flush();
    }    
}