<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectType;
use GC\DataLayerBundle\Entity\ProjectCreationProgress;
use GC\DataLayerBundle\Helpers;

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

/*
 *	 check for cookie
 *	 if cookie, redirect to appropriate phase
 *	 else, if post, update phase 1, create cookie redirect to phase 2
 *	 else, if get, render phase 1
 */
	public function newAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();

		if($request->cookies->has('continueCode')) {
			$code = $request->cookies->get('continueCode');
			$this->get('logger')->info("FOUND CONTINUE CODE: " . $code);
			$project = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->findOneById(187);
			$progress = $project->getProjectCreationProgress();
			switch($progress->getPhase()) {
				case 1: //category select
					$return = $this->render('GCDashboardBundle:Project:category_select.html.twig', array("id" => $code));;
					break;

				case 2: //project brief
					$return = $this->render('GCDashboardBundle:Project:project_brief.html.twig', array("id" => $code));
					break;

				case 3: //package select
					$return = $this->render('GCDashboardBundle:Project:package_select.html.twig', array("id" => $code));
					break;

				case 4: //payment
					$return = $this->render('GCDashboardBundle:Project:payment.html.twig', array("id" => $code));
					break;

				default: //start form over
					$return = $this->render('GCDashboardBundle:Project:new.html.twig');	

			}

		} else if($request->getMethod() == "POST") {			
			$projectType = $request->request->get('projectType');
			$project = new Project();
			$pt = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectType')->findOneBySlug($projectType);
			$project->setProjectType($pt);
			$em->persist($project);
			$code = Helpers::idToCode($project->getId());
			$progress = new ProjectCreationProgress();
			$progress->setPhase(1);
			$progress->setProject($project);
			$em->persist($progress);
			$em->flush();

			if ($request->isXmlHttpRequest()) {
				$return = json_encode(array("responseCode"=>200));
				$return = new Response($return, 200);
			} else {
				$return = $this->render('GCDashboardBundle:Project:category_select.html.twig', 
					array("id" => $code));	
				$cookie = new Cookie("continueCode", $code);
				$return->headers->setCookie($cookie);
			}				
		} else { // method == GET && no continue cookie
			$return = $this->render('GCDashboardBundle:Project:new.html.twig');	
		}
        
        return $return;
    }

    public function new_categoryAction(Request $request, $id) {
    	return $this->render('GCDashboardBundle:Project:category_select.html.twig');
    }
}
