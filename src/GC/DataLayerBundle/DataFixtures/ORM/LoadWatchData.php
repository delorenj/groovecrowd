<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\WatchCategory;
use GC\DataLayerBundle\Entity\WatchProject;


class LoadWatchData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 50;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $p = new WatchCategory();
        $p->setUser($manager->merge($this->getReference('user-creator')));
        $p->setCategory($manager->merge($this->getReference('category-game')));
        $manager->persist($p);

       	$p = new WatchProject();
        $p->setUser($manager->merge($this->getReference('user-creator')));
        $p->setProject($manager->merge($this->getReference('project-trailer')));
        $manager->persist($p);
        $manager->flush();
    }

}