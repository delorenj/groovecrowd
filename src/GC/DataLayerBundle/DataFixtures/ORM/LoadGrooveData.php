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


class LoadGrooveData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 30;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $p = new GrooveSet();
        $p->setUser($manager->merge($this->getReference('user-creator')));
        $p->setProject($manager->merge($this->getReference('project-game')));
        $p->setRating(4);
        $p->setPrivateComments(0);
        $p->setCreatedAt(new \DateTime("-3 day"));
        $this->addReference('gset-creator-game', $p);
        $manager->persist($p);
        $manager->flush();

        $p = new GrooveSet();
        $p->setUser($manager->merge($this->getReference('user-creator')));
        $p->setProject($manager->merge($this->getReference('project-fx')));
        $p->setPrivateComments(1);
        $p->setCreatedAt(new \DateTime("-2 day"));
        $this->addReference('gset-creator-fx', $p);
        $manager->persist($p);
        $manager->flush();

        $p = new Groove();
        $p->setGrooveSet($this->getReference('gset-creator-game'));
        $p->setGrooveType($manager->merge($this->getReference('groove-generic')));
        $p->setGrooveSlot($manager->merge($this->getReference('gs-game')));
        $p->setTitle("Plucked");
        $p->setDescription("This track features a lot of strings, with a very acoustic feel.");
        $p->setLengthInMilliseconds(91500);
        $p->setCreatedAt(new \DateTime("-3 day"));
        $manager->persist($p);
        $manager->flush();
    }
}