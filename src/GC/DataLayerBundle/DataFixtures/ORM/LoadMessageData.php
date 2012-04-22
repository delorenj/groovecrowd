<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\Message;


class LoadMessageData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 40;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $p = new Message();
        $p->setFromUser($manager->merge($this->getReference('user-creator')));
        $p->setToUser($manager->merge($this->getReference('user-consumer')));
        $p->setBody("Hey man, just wondering if you got a chance to see my upload yet? Thanks.");
        $p->setViewed(1);
        $p->setCreatedAt(new \DateTime("-22 minute"));
        $manager->persist($p);
        $manager->flush();

        $p = new Message();
        $p->setFromUser($manager->merge($this->getReference('user-consumer')));
        $p->setToUser($manager->merge($this->getReference('user-creator')));
        $p->setBody("Yea I saw it. Awesome stuff.");
        $p->setViewed(0);
        $p->setCreatedAt(new \DateTime("-12 minute"));
        $manager->persist($p);
        $manager->flush();
    }
}