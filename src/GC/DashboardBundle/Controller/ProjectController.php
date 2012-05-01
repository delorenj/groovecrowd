<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectType;
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

	public function newAction(Request $request) {
		if($request->getMethod() == "POST") {			
			$em = $this->getDoctrine()->getEntityManager();
			$projectType = $request->request->get('projectType');
			$project = new Project();
			$pt = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectType')->findOneBySlug($projectType);
			$project->setProjectType($pt);
			$em->persist($project);
			$em->flush();
			$code = Helpers::idToCode($project->getId());

			if($request->cookies->has('continueCode')) {
				$oldCode = $request->cookies->get('continueCode');
				$this->get('logger')->info("FOUND CONTINUE CODE: " . $oldCode);
				//do something...
			}

			$this->get('logger')->info("NEW CONTINUE CODE: " . $code);

			if ($request->isXmlHttpRequest()) {
				$return = json_encode(array("responseCode"=>200));
				return new Response($return, 200);
			} else {
				$return = $this->render('GCDashboardBundle:Project:category_select.html.twig', 
					array("id" => $code));	
				$cookie = new Cookie("continueCode", $code);
				$return->headers->setCookie($cookie);
			}				
		} else {
			$return = $this->render('GCDashboardBundle:Project:new.html.twig');	
		}
        
        return $return;
    }

    public function new_categoryAction(Request $request, $id) {
    	return $this->render('GCDashboardBundle:Project:category_select.html.twig');
    }
}
