<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
   public function indexAction()
    {
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

    	$now = time();
    	foreach($projects as $p) {
			$then = strtotime($p->getExpiresAt()->format('Y-m-d H:i:s'));
			$datediff = $then - $now;
			$p->remaining = floor($datediff/(60*60*24));
            $p->payoutAmount = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->getPayoutAmount($p); //REFACTOR 
			$p->grooveCount = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->getGrooveCount($p); //REFACTOR
    	}

        return $this->render('GCDashboardBundle:Default:consumer.html.twig', 
        	array('projects' => $projects));
	}

    public function creatorIndexAction() {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$userRepo = $this->userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');    	
    	$grooveSets = $user->getGrooveSets();
        return $this->render('GCDashboardBundle:Default:creator.html.twig', 
        	array('grooveSets' => $grooveSets));
	}	
}
