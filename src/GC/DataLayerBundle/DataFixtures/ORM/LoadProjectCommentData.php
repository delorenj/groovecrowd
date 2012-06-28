<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;	
use GC\DataLayerBundle\Entity\ProjectComment;


class LoadProjectCommentData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    protected $manager;
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder() {
        return 25;
    }

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
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-creator')));


        $p = new ProjectComment();
        $p->setUser($manager->merge($this->getReference('user-consumer')));
        $p->setProject($manager->merge($this->getReference('project-game')));
        $p->setCreatedAt(new \DateTime('-20 minute'));
        $p->setPrivate(0);
        $p->setBody("I'm picturing something with strings. Maybe a pizzacato string section. I'm not sure - surprised me lol");
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));


        $p = new ProjectComment();
        $p->setUser($manager->merge($this->getReference('test1')));
        $p->setProject($manager->merge($this->getReference('project-game')));
        $p->setCreatedAt(new \DateTime('-15 minute'));
        $p->setPrivate(0);
        $p->setBody("Can you add a few more examples to the inspriation board?");
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('test1')));
	}
}