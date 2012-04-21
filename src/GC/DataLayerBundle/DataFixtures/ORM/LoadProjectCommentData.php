<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\ProjectComment;


class LoadProjectCommentData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 25;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $p = new ProjectComment();
        $p->setUser($manager->merge($this->getReference('user-creator')));
        $p->setProject($manager->merge($this->getReference('project-game')));
        $p->setCreatedAt(new \DateTime('-30 minute'));
        $p->setPrivate(0);
        $p->setBody("Did you want something orchestral, or were you looking for something more electronic?");
        $this->manager->persist($p);
        $this->manager->flush();

        $p = new ProjectComment();
        $p->setUser($manager->merge($this->getReference('user-consumer')));
        $p->setProject($manager->merge($this->getReference('project-game')));
        $p->setCreatedAt(new \DateTime('-20 minute'));
        $p->setPrivate(0);
        $p->setBody("I'm picturing something with strings. Maybe a pizzacato string section. I'm not sure - surprised me lol");
        $this->manager->persist($p);
        $this->manager->flush();

        $p = new ProjectComment();
        $p->setUser($manager->merge($this->getReference('test1')));
        $p->setProject($manager->merge($this->getReference('project-game')));
        $p->setCreatedAt(new \DateTime('-15 minute'));
        $p->setPrivate(0);
        $p->setBody("Can you add a few more examples to the inspriation board?");
        $this->manager->persist($p);
        $this->manager->flush();

	}
}