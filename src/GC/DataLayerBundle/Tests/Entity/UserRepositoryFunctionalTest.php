<?php

namespace GC\DataLayerBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryFunctionalTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $repo;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->repo = $this->em->getRepository('GCDataLayerBundle:User');
    }

    public function testUserGrooveSetRelationship()
    {

        //Get main creator
        $user = $this->repo->findOneByUsernameCanonical('creator');
        $this->assertNotNull($user);

        //Get creator's groove sets
        $gs = $user->getGrooveSets();
        $this->assertCount(2, $gs);

        //Test inverse relationship
        foreach($gs as $x) {
            $this->assertNotNull($x->getUser());
            $this->assertEquals("creator", $x->getUser()->getUsernameCanonical());
        }
    }

    public function testUserGetActiveProjects()
    {

        //Get main consumer
        $user = $this->repo->findOneByUsernameCanonical('consumer');
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('ROLE_CONSUMER'), "Consumer found with wrong role.");    

        //find all active projects    
        $projects = $this->repo->findAllActiveProjects($user);
        $this->assertNotNull($projects);
        $this->assertCount(3, $projects);

    }    
}