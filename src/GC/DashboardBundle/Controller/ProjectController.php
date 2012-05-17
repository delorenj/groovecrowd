<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use GC\DataLayerBundle\Entity\User;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectType;
use GC\DataLayerBundle\Entity\ProjectCreationProgress;
use GC\DataLayerBundle\Helpers;
use GC\DashboardBundle\Form\Type\ProjectDescriptionType;
use GC\DashboardBundle\Form\Type\PackageSelectionType;
use GC\DashboardBundle\Form\Type\PaymentType;

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

	public function removeTagAction(Request $request, $id, $tag) {
		$this->get('logger')->info("removing tag $tag from project $id");
	 	$em = $this->getDoctrine()->getEntityManager();
		$repo = $this->getDoctrine()->getRepository("GCDataLayerBundle:Project");
		if($project = $repo->find($id)) {
				$repo->removeTag($project, $tag);
				$code = 200;				
		} else {
			$code = 404;
		}
		if ($request->isXmlHttpRequest()) {
			$return = json_encode(array("responseCode"=>$code));
			$return = new Response($return, $code);	
		} else {
			$return = json_encode(array("responseCode"=>304));
			$return = new Response($return, 304);	
		}
		return $return;
	}

	public function backAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();

		if($request->cookies->has('continueCode')) {
			$code = $request->cookies->get('continueCode');
			$this->get('logger')->info("FOUND CONTINUE CODE: " . $code);
			$progress = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectCreationProgress')->findOneByProject(Helpers::codeToId($code));			
			if(!$progress) {
				$return = $this->redirect('GCDashboardBundle:Project:new.html.twig', array("phase" => 0));
				$cookie = new Cookie('continueCode','');
				$return->headers->setCookie($cookie);
				return $return;
			}			

			if($progress->getPhase() > 0) {
				$progress->setPhase($progress->getPhase()-1);
				$em->persist($progress);
				$em->flush();
			}
		}

		return $this->forward("GCDashboardBundle:Project:new", array("phase" => $progress->getPhase()));

	}
/*
 *	 check for cookie
 *	 if cookie, redirect to appropriate phase
 *	 else, if post, update phase 1, create cookie redirect to phase 2
 *	 else, if get, render phase 1
 */
	public function newAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();
		$request->getSession()->set("_gc.target_path", "project_new");
		if($request->cookies->has('continueCode')) {
			$code = $request->cookies->get('continueCode');
			$this->get('logger')->info("FOUND CONTINUE CODE: " . $code);
			$progress = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectCreationProgress')->findOneByProject(Helpers::codeToId($code));			
			if(!$progress) {
				$return = $this->render('GCDashboardBundle:Project:new.html.twig', array("phase" => 0));
				$cookie = new Cookie('continueCode','');
				$return->headers->setCookie($cookie);
			}
			$project = $progress->getProject();

			if($request->getMethod() == "GET") {
				switch($progress->getPhase()) {
					case 1: //category select
						$return = $this->render('GCDashboardBundle:Project:category_select.html.twig', array("phase" => 1));
					break;

					case 2: //project brief
						$form = $this->createForm(new ProjectDescriptionType(), $project);
						$tags = $project->getTags();
						$t[] = null;
						foreach($tags as $tag) {
							$t[] = $tag->getName();
						}
						$tag_list = implode(',', $t);
						$return = $this->render('GCDashboardBundle:Project:project_brief.html.twig', 
							array("phase" => 2, "form" => $form->createView(), "tag_list" => $tag_list, "id" => $project->getId()));
					break;

					case 3: //package select
						$price_repo = $em->getRepository('GCDataLayerBundle:PriceMap');
						$form = $this->createForm(new PackageSelectionType(), $project);					
						$prices = $price_repo->getPackagePrices($project, "bronze");
						$return = $this->render('GCDashboardBundle:Project:package_select.html.twig', array("id" => $code, "phase" => 3, "project" => $project, "prices" => $prices, "form" => $form->createView()));
					break;

					case 4: //payment
						$project_repo = $em->getRepository('GCDataLayerBundle:Project');
						$userManager = $this->container->get('fos_user.user_manager');											
				    	$user = $this->get('security.context')->getToken()->getUser();
				    	if($user == "anon.") {
				    		$user = $userManager->createUser();
				    	}
						$form = $this->createForm(new PaymentType(), $user);
						$csrf = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
						$price = $project_repo->getPrice($project);				
						$return = $this->render('GCDashboardBundle:Project:payment.html.twig', array("csrf" => $csrf, "id" => $code, "phase" => 4, "user" => $user, "project" => $project, "price" => $price, "form" => $form->createView()));
					break;

					default: //start form over
						$return = $this->render('GCDashboardBundle:Project:new.html.twig', array("phase" => 0));	

				}				
			} else {
				switch($progress->getPhase()) {
					case 0: //groove type select (only on back)
						$projectType = $request->request->get('projectType');
						$pt = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectType')->findOneBySlug($projectType);
						$project->setProjectType($pt);
						$em->persist($project);
						$em->flush();			
						$progress->setPhase(1);
						$em->persist($progress);
						$em->flush();
						$return = $this->render('GCDashboardBundle:Project:category_select.html.twig', array("id" => $code, "phase" => 1));	
					break;

					case 1: //category select
						$cat = $request->request->get('category');
						$cat = $em->getRepository('GCDataLayerBundle:Category')->findOneBySlug($cat);
						$project->setCategory($cat);
						$em->persist($project);
						$em->flush();
						$progress->setPhase(2);
						$em->persist($progress);
						$em->flush();	
						$form = $this->createForm(new ProjectDescriptionType(), $project);
						$tags = $project->getTags();
						$t[] = null;
						foreach($tags as $tag) {
							$t[] = $tag->getName();
						}
						$tag_list = implode(',', $t);
						$return = $this->render('GCDashboardBundle:Project:project_brief.html.twig', 
							array("phase" => 2, "form" => $form->createView(), "tag_list" => $tag_list, "id" => $project->getId()));
					break;
						break;

					case 2: //project brief
						$form = $this->createForm(new ProjectDescriptionType(), $project);
						$form->bindRequest($request);
						if($form->isValid()) {
							$repo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Tag');
							$pd = $request->request->get('projectDescription');
							$tags = explode(',', $pd['tag_list']);
					        foreach($tags as $tag) {
					            $t = $repo->createIfNotExists($tag);
					            $project->addTag($t);
					        }
							$em->persist($project);
							$em->flush();	
							$progress->setPhase(3);
							$em->persist($progress);
							$em->flush();	
							$price_repo = $em->getRepository('GCDataLayerBundle:PriceMap');
							$form = $this->createForm(new PackageSelectionType(), $project);						
							$prices = $price_repo->getPackagePrices($project, "bronze");
							$return = $this->render('GCDashboardBundle:Project:package_select.html.twig', array("id" => $code, "phase" => 3, "project" => $project, 
								"prices" => $prices, "form" => $form->createView()));
						} else {
							$return = $this->render('GCDashboardBundle:Project:project_brief.html.twig', 
								array("phase" => 2, "form" => $form->createView(), "tag_list" => $tag_list, "id" => $project->getId()));
						}
						
					break;

					case 3: //package select
						$form = $this->createForm(new PackageSelectionType(), $project);
						$form->bindRequest($request);
						if($form->isValid()) {
							$repo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Package');
							$packageName = $request->request->get('packageSelection');
							$packageName = $packageName['package'];
							$project->setPackage($repo->findOneBySlug($packageName));
							$em->persist($project);
							$em->flush();	
							$progress->setPhase(4);
							$em->persist($progress);
							$em->flush();
							$project_repo = $em->getRepository('GCDataLayerBundle:Project');
							$user = new User();
							$form = $this->createForm(new PaymentType(), $user);
							$price = $project_repo->getPrice($project);				
							$return = $this->render('GCDashboardBundle:Project:payment.html.twig', array("id" => $code, "phase" => 4, "user" => $user, "project" => $project, "price" => $price, "form" => $form->createView()));
						} else {
							$return = $this->render('GCDashboardBundle:Project:package_select.html.twig', array("id" => $code, "phase" => 3, 
								"project" => $project, "prices" => $prices, "form" => $form->createView()));
						}					

					break;

					case 4: //payment
						$userManager = $this->container->get('fos_user.user_manager');					
				    	$user = $this->get('security.context')->getToken()->getUser();
				    	if($user == "anon.") {
				    		$user = $userManager->createUser();
				    	}					
						$project_repo = $em->getRepository('GCDataLayerBundle:Project');						
						$form = $this->createForm(new PaymentType(), $user);
						$form->bindRequest($request);
						if($form->isValid()) {
					        if(!$user->hasRole('USER')) {
					        	$user->setImage("default.jpg");
					        	$user->setEnabled(1);
					        	$user->addRole("ROLE_CONSUMER");
					        	$userManager->updateUser($user);
					        }
							$progress->setPhase(4); //CHANGE!
							$em->persist($progress);
							$em->flush();
							$project->setEnabled(1);
							$project->setUser($user);
							$project->setCreatedAt(new \DateTime("now"));
        					$p->setExpiresAt(new \DateTime("now + " . $p->getContestLength() . " day"));
							$em->persist($project);
							$em->flush();
							$cookie = new Cookie('continueCode','');
							$return = $this->redirect('GCDashboardBundle:Default:index.html.twig');
							$return->headers->setCookie($cookie);														
						} else {
							$price = $project_repo->getPrice($project);											
							$return = $this->render('GCDashboardBundle:Project:payment.html.twig', array("id" => $code, "phase" => 4, "user" => $user, 
								"project" => $project, "price" => $price, "form" => $form->createView()));

						}					
					break;

					default: //start form over
						$return = $this->render('GCDashboardBundle:Project:new.html.twig', array("phase" => 0));						
					break;
				}// end switch: POST			
			}// end if continueCode found
		}
		else { // if no continue code found...
			if($request->getMethod() == "POST") {
				$projectType = $request->request->get('projectType');
				$project = new Project();
				$pt = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectType')->findOneBySlug($projectType);
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
					$return = $this->render('GCDashboardBundle:Project:category_select.html.twig', array("id" => $code, "phase" => 1));	
					$cookie = new Cookie("continueCode", $code);
					$return->headers->setCookie($cookie);
				}

			} //end no continue POST
			else {
				$return = $this->render('GCDashboardBundle:Project:new.html.twig', array("phase" => 0));
			}// end no continue GET
		} //end no continue block
        return $return;
    }

}
