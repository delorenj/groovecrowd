<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentController extends Controller
{
   public function indexAction()
    {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$userRepo = $this->userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');
    	if($user->hasRole('ROLE_USER')) {
    		return $this->forward('GCDashboardBundle:Default:creatorIndex');
    		return $r;
    	} elseif($user->hasRole('ROLE_CONSUMER')) {
    		return $this->forward('GCDashboardBundle:Default:consumerIndex');
    	}
    }

}
