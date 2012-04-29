<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\PriceMap;


class LoadPriceMapData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 50;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-bronze'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-music'))->getId());
        $p->setPayout(150);
        $p->setPrice(199);
        $manager->persist($p);

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-bronze'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-voice-over'))->getId());
        $p->setPayout(150);
        $p->setPrice(199);
        $manager->persist($p);

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-bronze'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-audio-fx'))->getId());
        $manager->persist($p);    
        $p->setPayout(150);
        $p->setPrice(199);


###################

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-silver'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-music'))->getId());
        $p->setPayout(340);
        $p->setPrice(399);
        $manager->persist($p);

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-silver'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-voice-over'))->getId());
        $p->setPayout(340);
        $p->setPrice(399);
        $manager->persist($p);

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-silver'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-audio-fx'))->getId());
        $manager->persist($p);    
        $p->setPayout(340);
        $p->setPrice(399);        



###################

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-gold'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-music'))->getId());
        $p->setPayout(600);
        $p->setPrice(699);
        $manager->persist($p);

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-gold'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-voice-over'))->getId());
        $p->setPayout(600);
        $p->setPrice(699);
        $manager->persist($p);

        $p = new PriceMap();
        $p->setPackageId($manager->merge($this->getReference('package-gold'))->getId());
        $p->setProjectTypeId($manager->merge($this->getReference('project-type-audio-fx'))->getId());
        $manager->persist($p);    
        $p->setPayout(600);
        $p->setPrice(699);        



        $manager->flush();
    }    
}