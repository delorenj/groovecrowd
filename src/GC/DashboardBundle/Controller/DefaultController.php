<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use GC\DataLayerBundle\Helpers;

class DefaultController extends Controller
{
   public function indexAction()
    {
        $this->get('logger')->info('Here');
    	$user = $this->get('security.context')->getToken()->getUser();
    	$userRepo = $this->userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');
    	if($user->hasRole('ROLE_CREATOR')) {
    		return $this->forward('GCDashboardBundle:Default:creatorIndex');
    		return $r;
    	} elseif($user->hasRole('ROLE_CONSUMER')) {
    		return $this->forward('GCDashboardBundle:Default:consumerIndex');
    	}
    }

    public function consumerIndexAction() {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');  	
    	$projects = $userRepo->findAllActiveProjects($user);
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
    	$now = time();
    	foreach($projects as $p) {
			$then = strtotime($p->getExpiresAt()->format('Y-m-d H:i:s'));
			$datediff = $then - $now;
			$p->remaining = floor($datediff/(60*60*24));
            $p->payoutAmount = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->getPayoutAmount($p); //REFACTOR 
			$p->grooveCount = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->getGrooveCount($p); //REFACTOR
    	}

        if($this->getRequest()->isXmlHttpRequest()) {
            $this->get('logger')->info('Ajax Request');
            $projectArray = array();
            foreach($projects as $p) {
                $projectArray[] = $p->toArray();
            }
            return new Response(json_encode($projectArray), 200);
        } else {
            return $this->render('GCDashboardBundle:Default:consumer.html.twig');    
        }        
	}

    public function creatorIndexAction() {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$userRepo = $this->userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');    	
    	$grooveSets = $user->getGrooveSets();
        return $this->render('GCDashboardBundle:Default:creator.html.twig', 
        	array('grooveSets' => $grooveSets));
	}

}
