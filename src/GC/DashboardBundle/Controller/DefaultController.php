<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{

    public function indexAction()
    {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$userRepo = $this->userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');
    	$projects = $userRepo->findAllActiveProjects($user);
        return $this->render('GCDashboardBundle:Default:index.html.twig', 
        	array('projects' => $projects));
    }
}
