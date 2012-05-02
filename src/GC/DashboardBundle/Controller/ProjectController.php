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
			$progress = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectCreationProgress')->findOneByProject(Helpers::codeToId($code));			
			if(!$progress) {
				$return = $this->render('GCDashboardBundle:Project:new.html.twig');	
			}
			$project = $progress->getProject();

			if($request->getMethod() == "GET") {
				switch($progress->getPhase()) {
					case 1: //category select
						$return = $this->render('GCDashboardBundle:Project:category_select.html.twig');
						break;

					case 2: //project brief
						$return = $this->render('GCDashboardBundle:Project:project_brief.html.twig');
						break;

					case 3: //package select
						$return = $this->render('GCDashboardBundle:Project:package_select.html.twig');
						break;

					case 4: //payment
						$return = $this->render('GCDashboardBundle:Project:payment.html.twig');
						break;

					default: //start form over
						$return = $this->render('GCDashboardBundle:Project:new.html.twig');	

				}				
			} else {
				switch($progress->getPhase()) {
					case 1: //category select
						$this->get('logger')->info('GET PROJECT: ' . $project->getId());
						$return = $this->render('GCDashboardBundle:Project:category_select.html.twig');
					break;

					case 2: //project brief
						$return = $this->render('GCDashboardBundle:Project:project_brief.html.twig');
					break;

					case 3: //package select
						$return = $this->render('GCDashboardBundle:Project:package_select.html.twig');
					break;

					case 4: //payment
						$return = $this->render('GCDashboardBundle:Project:payment.html.twig');
					break;

					default: //start form over
						$return = $this->render('GCDashboardBundle:Project:new.html.twig');						
					break;
				}// end switch: POST			
			}// end if continueCode found
		}
		else { // if no continue code found...
			if($request->getMethod() == "POST") {
				$projectType = $request->request->get('projectType');
				$project = new Project();
				$pt = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectType')->findOneBySlug($projectType);
				if(!$pt) {
					$this->createNotFoundException("ProjectType not found: " . $projectType);
				}
				$project->setProjectType($pt);
				$em->persist($project);
				$em->flush();			
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

			} //end no continue POST
			else {
				$return = $this->render('GCDashboardBundle:Project:new.html.twig');
			}// end no continue GET
		} //end no continue block
        return $return;
    }

}
