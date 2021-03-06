<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GC\DataLayerBundle\Entity\User;
class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder() {
        return 10;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        //admin
        $user = $userManager->createUser();
        $user->setUsername("admin");
        $user->setPlainPassword("admin123");
        $user->setEmail("admin@groovecrowd.com");
        $user->setImage("admin.png");
        $user->addRole("ROLE_ADMIN");
        $user->setEnabled(true);
        $userManager->updateUser($user);
        $this->addReference('user-admin', $user);

        //test consumer
        $user = $userManager->createUser();
        $user->setUsername("consumer");
        $user->setPlainPassword("test");
        $user->setFirstName("Jarad");
        $user->setLastName("DeLorenzo");
        $user->setEmail("consumer@sweetshoes.com");
        $user->setEnabled(true);       
        $user->addRole("ROLE_CONSUMER"); 
        $user->setImage("admin.png");
        $userManager->updateUser($user);
        $this->addReference('user-consumer', $user);

        //test creator
        $user = $userManager->createUser();
        $user->setUsername("creator");
        $user->setFirstName("Boathro");
        $user->setLastName("Larmtran");
        $user->setPlainPassword("test");
        $user->setEmail("creator@bootsandass.com");
        $user->setEnabled(true);       
        $user->addRole("ROLE_CREATOR"); 
        $user->setImage("default.jpg");
        $userManager->updateUser($user);
        $this->addReference('user-creator', $user);

        //test creator 2
        $user = $userManager->createUser();
        $user->setUsername("creator2");
        $user->setPlainPassword("test");
        $user->setEmail("anothercreator@gravybrush.com");
        $user->setEnabled(true);       
        $user->addRole("ROLE_CREATOR"); 
        $user->setImage("default.jpg");
        $userManager->updateUser($user);
        $this->addReference('user-creator2', $user);

        //disabled account
        $user = $userManager->createUser();
        $user->setUsername("test0");
        $user->setPlainPassword("test");
        $user->setEmail("test0@testies.com");
        $user->setEnabled(false);        
        $user->setImage("default.jpg");
        $userManager->updateUser($user);
        $this->addReference('user-disabled', $user);

        for($i=1; $i<30; $i++) {
            $user = $userManager->createUser();
            $user->setUsername("test" . $i);
            $user->setPlainPassword("test");
            $user->setFirstName("Tractors");
            $user->setLastName("Hambone");
            $user->setEmail("test" . $i . "@testies.com");
            $user->setEnabled(true);
            $user->addRole("ROLE_CONSUMER");  
            $user->setImage("default.jpg");           
            $userManager->updateUser($user); 
            $this->addReference('test' . $i, $user);           
        }

    }
}
