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
    	$user = $this->get('security.context')->getToken()->getUser();
    	$userRepo = $this->userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');
    	if($user->hasRole('ROLE_CREATOR')) {
    		return $this->forward('GCDashboardBundle:Default:creatorIndex');
    	} elseif($user->hasRole('ROLE_CONSUMER')) {
    		return $this->forward('GCDashboardBundle:Project:consumerIndex');
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
