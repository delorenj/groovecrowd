<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\Category;

class LoadSimpleData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 1;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $app = $this->add("Application");
        $this->add("Game", $app->getId());
    }

    private function add($name, $parent = NULL) {
        $cat = new Category();
        $cat->setName($name);
        if($parent) {
            $cat->setParentId($parent);
        }
        $cat->setCount(0);
        $this->manager->persist($cat);
        $this->manager->flush();
        return $cat;
    }
}
