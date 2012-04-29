<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectType;

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

	public function newAction(Request $request) {
		// $request = $this->getRequest();		
		if($request->getMethod() == "POST") {
			$this->get('logger')->info($this->get('request')->request->get('projectType'));
			
			$em = $this->getDoctrine()->getEntityManager();
			$projectType = $request->request->get('projectType');
			$project = new Project();
			$pt = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectType')->findOneByName($projectType);
			$project->setProjectType($pt);
			$em->persist($project);
			$em->flush();

			if ($request->isXmlHttpRequest()) {
				$return = json_encode(array("responseCode"=>200));
				return new Response($return, 200);
			} else {
				$return = $this->render('GCDashboardBundle:Project:category_select.html.twig');	
			}				
		} else {
			$return = $this->render('GCDashboardBundle:Project:new.html.twig');	
		}
        
        return $return;
    }
}
