<?php

namespace GC\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GC\ProjectBundle\Entity\User;

class LoadProjectData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder() {
        return 8;
    }

    public function load(ObjectManager $manager)
    {
        // $userAdmin = new User();
        // $userAdmin->setUsername('admin');
        // $userAdmin->setPassword('admin123');
        // $userAdmin->setEmail("admin@test.com");
        // $userAdmin->setFirstName("Shanto");
        // $userAdmin->setLastName("Bishtweed");
        // $manager->persist($userAdmin);
        // $manager->flush();
        // $userManager = $this->container->get('fos_user.user_manager');
        // $user = $userManager->createUser();
        // $user->setUsername("admin");
        // $user->setPassword("admin123");
        // $user->setEmail("admin@groovecrowd.com");
        // $user->setFirstName("Shamus");
        // $user->setLastName("Ballsham");
        // $userManager->updateUser($user);

        // $user = $userManager->createUser();
        // $user->setUsername("admin");
        // $user->setPassword("admin123");
        // $user->setEmail("admin@groovecrowd.com");
        // $user->setFirstName("Shamus");
        // $user->setLastName("Ballsham");
        // $userManager->updateUser($user);

    }
}
