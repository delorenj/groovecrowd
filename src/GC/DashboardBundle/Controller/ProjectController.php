<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProjectController extends Controller
{
   public function indexAction()
    {
        return new Response("todo");
    }

    public function showAction($id) {
    	$project = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->find($id);

        return $this->render('GCDashboardBundle:Project:show.html.twig', 
        	array('project' => $project));
	}
}
