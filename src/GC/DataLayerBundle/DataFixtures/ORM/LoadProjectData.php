<?php

namespace GC\DataLayerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;	
use GC\DataLayerBundle\Entity\Category;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectAsset;
use GC\DataLayerBundle\Entity\Package;
use GC\DataLayerBundle\Entity\GrooveSlot;

class LoadProjectData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    protected $manager;
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder() {
        return 20;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $p = new Project();
        $p->setUser($manager->merge($this->getReference('user-consumer')));
        $p->setTitle("Addictive song for a new iOS strategy game");
        $p->setOrganization("Self");
        $p->setDescription("I need a catchy song to accompany my strategy game.  I'm looking for something happy and playful - something like the background music in Cut The Rope.  If I like it I may need a few more for other levels.");
        $p->setCategory($manager->merge($this->getReference('category-game')));
        $p->setProjectType($manager->merge($this->getReference('project-type-music')));
        $p->setPackage($manager->merge($this->getReference('package-silver')));
        $p->setPayoutGuaranteed(1);
        $p->setEnabled(1);
        $p->setFullGrooveSetsOnly(1);
        $p->setBlind(0);
        $p->addTag($manager->merge($this->getReference('tag-playful')));
        $p->addTag($manager->merge($this->getReference('tag-pizzacato')));
        $p->addTag($manager->merge($this->getReference('tag-video-game')));
        $p->setContestLength(15);
        $postedDate = "-2 week";        
        $p->setCreatedAt(new \DateTime($postedDate));
        $p->setExpiresAt(new \DateTime($postedDate . " + " . $p->getContestLength() . " day"));
        $p->setFlags(0);
        $this->addReference('project-game', $p);
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('logger')->info('ACL:: About to bind to ACL');
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));

        $p = new ProjectAsset();
        $p->setProject($this->getReference('project-game'));
        $p->setUri("https://s3.amazonaws.com/groovecrowd/test/image3.jpg");
        $p->setThumbUri("https://s3.amazonaws.com/groovecrowd/test/thumbs/image3.jpg");        
        $p->setCaption("This is a sweet image to test the media gallery");
        $p->setCreatedAt(new \DateTime("now"));
        $p->setAssetType($manager->merge($this->getReference('asset-image')));
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));        

        $p = new ProjectAsset();
        $p->setProject($this->getReference('project-game'));
        $p->setUri("https://s3.amazonaws.com/groovecrowd/test/audio1.mp3");
        $p->setThumbUri("/img/audiodefault.png");        
        $p->setCaption("One of the best Bill Evans songs!");
        $p->setCreatedAt(new \DateTime("now"));
        $p->setAssetType($manager->merge($this->getReference('asset-audio')));
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));        

        $p = new ProjectAsset();
        $p->setProject($this->getReference('project-game'));
        $p->setUri("test/video1.mp4");
        $p->setThumbUri("https://s3.amazonaws.com/groovecrowd/test/video1.jpg");  
        $p->setCaption("Check out this video, which tests the extent of my ballos");              
        $p->setCreatedAt(new \DateTime("now"));
        $p->setAssetType($manager->merge($this->getReference('asset-video')));
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));        

        $p = new Project();
        $postedDate = "now";
        $p->setUser($manager->merge($this->getReference('user-consumer')));
        $p->setTitle("Intense soundtrack for my new iOS game trailer");
        $p->setOrganization("Self");
        $p->setDescription("I'm looking for an intense, maybe Techno style soundtrack for my 30 second game trailer.");
        $p->setProjectType($manager->merge($this->getReference('project-type-music')));
        $p->setCategory($manager->merge($this->getReference('category-game')));
        $p->setPackage($manager->merge($this->getReference('package-silver')));
        $p->setPayoutGuaranteed(1);
        $p->setEnabled(1);
        $p->setFullGrooveSetsOnly(1);
        $p->setBlind(1);
        $p->addTag($manager->merge($this->getReference('tag-playful')));
        $p->addTag($manager->merge($this->getReference('tag-trailer')));
        $p->addTag($manager->merge($this->getReference('tag-industrial')));
        $p->setContestLength(15);        
        $postedDate = "now";        
        $p->setCreatedAt(new \DateTime($postedDate));
        $p->setExpiresAt(new \DateTime($postedDate . " + " . $p->getContestLength() . " day"));
        $p->setFlags(0);
        $this->addReference('project-trailer', $p);
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));

        $p = new ProjectAsset();
        $p->setProject($this->getReference('project-trailer'));
        $p->setUri("http://vimeo.com/35692677");
        $p->setCreatedAt(new \DateTime("-1 week"));
        $p->setAssetType($manager->merge($this->getReference('asset-image')));
        $this->manager->persist($p);
        $this->manager->flush();    
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));


        //Come back to set winner later...
        $p = new Project();
        $p->setUser($manager->merge($this->getReference('user-consumer')));
        $p->setTitle("A set of sound effects for my new strategy game");
        $p->setOrganization("Self");
        $p->setDescription("I need a set of quality sound effects for a few key actions in my iOS game.");
        $p->setProjectType($manager->merge($this->getReference('project-type-audio-fx')));
        $p->setCategory($manager->merge($this->getReference('category-game')));
        $p->setPackage($manager->merge($this->getReference('package-bronze')));
        $p->setPayoutGuaranteed(0);
        $p->setEnabled(1);
        $p->setFullGrooveSetsOnly(0);
        $p->setBlind(1);
        $p->addTag($manager->merge($this->getReference('tag-effects')));
        $p->addTag($manager->merge($this->getReference('tag-fx')));
        $p->addTag($manager->merge($this->getReference('tag-sounds')));
        $p->setContestLength(7);        
        $postedDate = "-2 week";        
        $p->setCreatedAt(new \DateTime($postedDate));
        $p->setExpiresAt(new \DateTime($postedDate . " + " . $p->getContestLength() . " day"));
        $p->setFlags(0);
        $this->addReference('project-fx', $p);
        $this->manager->persist($p);
        $this->manager->flush();
        $this->container->get('acl_helper')->bindUserToObject($p, MaskBuilder::MASK_OPERATOR, $manager->merge($this->getReference('user-consumer')));
          

        $p = new GrooveSlot();
        $p->setProject($this->getReference('project-fx'));
        $p->setDescription("Interface: Click/Select.  Like a pleasant 'pingy' noise");
        $this->manager->persist($p);
        $this->manager->flush();  

        $p = new GrooveSlot();
        $p->setProject($this->getReference('project-fx'));
        $p->setDescription("Heavy rolling ball sound. Needs to loop smoothly");
        $this->manager->persist($p);
        $this->manager->flush();  

        $p = new GrooveSlot();
        $p->setProject($this->getReference('project-trailer'));
        $p->setDescription('A happy congratulations noise for when a bonus is scored');
        $p->addTag($manager->merge($this->getReference('tag-score')));
        $p->addTag($manager->merge($this->getReference('tag-level-up')));
        $this->addReference('gs-congrats', $p);
        $this->manager->persist($p);
        $this->manager->flush();

    }


}
