<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GC\DataLayerBundle\Entity\Category;
use GC\DataLayerBundle\Helpers;

class LoadCategoryData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder() {
        return 2;
    }

    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $root = $this->add("root");
        $game = $this->add("Game", $root->getId());
        $this->add("Console", $game->getId());
        $this->add("PC", $game->getId());
        $this->add("Mobile", $game->getId());

        $this->add("Brand Jingle", $root->getId());

        $video = $this->add("Video", $root->getId());
        $this->add("Advertisement", $video->getId());
        $this->add("Web Series", $video->getId());
        $anim = $this->add("Animation", $video->getId());

        $other = $this->add("Other", $root->getId());

        $root->setLft(1);
        $rgt = $this->rebuild_tree($root, 1);
        $root->setRgt($rgt+1);
        $this->manager->persist($root);
        $this->manager->flush();
    }

    private function rebuild_tree($root, $lft=0) {
        $children = $this->manager->getRepository('GC\DataLayerBundle\Entity\Category')->findBy(array('parentId' => $root->getId()));
        foreach($children as $root) {
            $root->setLft($lft+1);
            $rgt = $this->rebuild_tree($root, $lft+1);
            $root->setRgt($rgt+1);
            $this->manager->persist($root);
            $this->manager->flush();            
            $lft=$rgt+1;
        }
        return $lft;
    }

    private function add($name, $parent = NULL) {
        $cat = new Category();
        $cat->setName($name);
        if($parent) {
            $cat->setParentId($parent);
        }
        $cat->setCount(0);
        $this->addReference("category-" . Helpers::slugify($name), $cat);
        $this->manager->persist($cat);
        $this->manager->flush();
        return $cat;
    }
}
