<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\Groove;
use GC\DataLayerBundle\Entity\GrooveSet;
use GC\DataLayerBundle\Entity\GrooveSlot;
use GC\DataLayerBundle\Entity\GrooveType;
use GC\DataLayerBundle\Entity\GrooveComment;


class LoadGrooveData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 30;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $p = new Groove();
        $p->setUser($manager->merge($this->getReference('user-creator')));        
        $p->setProject($manager->merge($this->getReference('project-game')));        
        $p->setGrooveType($manager->merge($this->getReference('groove-generic')));
        $p->setTitle("Cave In");
        $p->setUri("http://groovecrowd.local/app_dev.php/grooves/cavein.mp3");
        $p->setDescription("This track features a lot of strings, with a very acoustic feel.");
        $p->setLengthInMilliseconds(91500);
        $p->setRating(3);
        $p->setCreatedAt(new \DateTime("-3 day"));
        $this->addReference('groove-cave-in', $p);        
        $manager->persist($p);
        $manager->flush();

        $p = new GrooveComment();
        $p->setUser($manager->merge($this->getReference('user-consumer')));
        $p->setGroove($manager->merge($this->getReference('groove-cave-in')));
        $p->setCreatedAt(new \DateTime('-20 minute'));
        $p->setBody("Where have I heard this before?...");
        $this->manager->persist($p);
        $this->manager->flush();        


        $p = new Groove();
        $p->setUser($manager->merge($this->getReference('user-creator')));                
        $p->setProject($manager->merge($this->getReference('project-fx')));        
        $p->setGrooveType($manager->merge($this->getReference('groove-fx')));
        $p->setUri("http://groovecrowd.local/app_dev.php/grooves/buzzer.mp3");
        $p->setTitle("Blingy happy noise");
        $p->setRating(2);        
        $p->setLengthInMilliseconds(1500);
        $p->setCreatedAt(new \DateTime("-1 day"));
        $this->addReference('groove-congrats', $p);        
        $manager->persist($p);
        $manager->flush();

        $p = new Groove();
        $p->setUser($manager->merge($this->getReference('user-creator')));        
        $p->setProject($manager->merge($this->getReference('project-fx')));        
        $p->setGrooveType($manager->merge($this->getReference('groove-fx')));
        $p->setUri("http://groovecrowd.local/app_dev.php/grooves/window_break1.wav");
        $p->setTitle("Break noise");
        $p->setRating(5);        
        $p->setLengthInMilliseconds(2100);
        $p->setCreatedAt(new \DateTime("-10 hour"));
        $this->addReference('groove-congrats2', $p);        
        $manager->persist($p);
        $manager->flush();
    }
}