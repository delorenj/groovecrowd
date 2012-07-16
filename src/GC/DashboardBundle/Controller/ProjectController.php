<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectType;
use GC\DashboardBundle\Form\Type\ProjectDescriptionType;
use GC\DataLayerBundle\Entity\ProjectAsset;
use GC\DataLayerBundle\Entity\ProjectComment;
use GC\DataLayerBundle\Helpers;

class ProjectController extends Controller
{
   public function consumerIndexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');      
        $projects = $projectRepo->findAllActiveProjects($user);

        if($this->getRequest()->isXmlHttpRequest()) {
            $this->get('logger')->info('Ajax Request');
            $projectArray = array();
            foreach($projects as $idx=>$p) {
                $projectArray[$idx] = $p->toArray();
                $projectArray[$idx]["endedAndNoWinnerYet"] = ($p->getWinningGroove() == null) && ($p->getExpiresAt() < new \DateTime() );
            }
            return new Response(json_encode($projectArray), 200);
        } else {
            foreach($projects as $idx=>&$p) {
                $p->endedAndNoWinnerYet = ($p->getWinningGroove() == null) && ($p->getExpiresAt() < new \DateTime() );
            }            
            return $this->render('GCDashboardBundle:Project:index.html.twig', array("projects" => $projects));
        }
    }

   public function pastAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');      
        $projects = $projectRepo->findAllPastProjects($user);

        if($this->getRequest()->isXmlHttpRequest()) {
            $this->get('logger')->info('Ajax Request');
            $projectArray = array();
            foreach($projects as $idx=>$p) {
                $projectArray[$idx] = $p->toArray();
                $projectArray[$idx]["endedAndNoWinnerYet"] = false;
            }
            return new Response(json_encode($projectArray), 200);
        } else {
            foreach($projects as $idx=>&$p) {
                $p->endedAndNoWinnerYet = false;
            }                        
            return $this->render('GCDashboardBundle:Project:past.html.twig', array("projects" => $projects));
        }
    }

    public function commentsAction($id) {
        $em = $this->getDoctrine()->getEntityManager();    
        $user = $this->get('security.context')->getToken()->getUser();
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');  
        $request = $this->getRequest();

        if(!$p = $projectRepo->find($id)) {
            throw $this->createNotFoundException('The project does not exist');
        }

        if($request->getMethod() == "GET") {
            $this->get('logger')->info('COMMENT: Getting comments for project ' . $id);
            $comments = $p->toArray();
            $comments = $comments["comments"];
            $this->get('logger')->info('COMMENT: Number of comments --> ' . count($comments));            
            foreach ($comments as &$c) {
                $c["canDelete"] = $this->get('acl_helper')->canDelete($c);
            }
            $response = new Response(json_encode($comments), 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else if($request->getMethod() == "POST") {
            $payload = $request->getContent();
            if(!empty($payload)) {
                $params = json_decode($payload, true);
            } else {
                return new Response(json_encode(array("OK" => "0", "msg" => "Invalid comment post")), 500);            
            }
            $this->get('logger')->info('COMMENT: Creating a new comment object');
            $comment = new ProjectComment();
            $comment->setBody($params["body"]);
            $comment->setProject($p);
            $comment->setCreatedAt(new \DateTime());
            $comment->setPrivate(false);
            $comment->setUser($user);
            $em->persist($comment);
            $em->flush();
            $this->get('acl_helper')->bindUserToObject($comment, MaskBuilder::MASK_OPERATOR);
            $this->get('acl_helper')->bindUserToObject($comment, MaskBuilder::MASK_DELETE, $p->getUser());
            return new Response(json_encode($comment), 200);
        }

    }

    public function assetsAction($id) {
        $em = $this->getDoctrine()->getEntityManager();    
        if(!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return new Response(json_encode(array("OK" => "0", "msg" => "Log in to view project media")), 500);            
        }
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');  
        $request = $this->getRequest();

        if(!$p = $projectRepo->find($id)) {
            throw $this->createNotFoundException('The project does not exist');
        }

        $assets = $p->toArray();
        $assets = $assets["assets"];
        $response = new Response(json_encode($assets), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;


    }

    public function showAction($id) {
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');      
        $p = $projectRepo->find($id);
        return $this->render('GCDashboardBundle:Project:show.html.twig', array("project" => $p));
    }

    public function groovesAction($id) {
        $request = $this->getRequest();        
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');      
        $grooveRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Groove');      
        $p = $projectRepo->find($id);
        $g = $grooveRepo->findByProject($id);

        if($request->isXmlHttpRequest()) {
            foreach($g as $idx=>$groove) {
                $this->get('logger')->info('GROOVES: idx=' . $idx);
                $grooves[$idx] = $groove->toArray();
                $grooves[$idx]["readonly"] = $this->get('acl_helper')->canEdit($p) ? "0":"1";
            }

            $this->get('logger')->info('GROOVES: Number of grooves --> ' . count($grooves));
            $response = new Response(json_encode($grooves), 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else if($request->getMethod() == "GET") {
            return $this->render('GCDashboardBundle:Project:grooves.html.twig', array("project" => $p, "grooves" => $g));
        }
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $userManager = $this->container->get('fos_user.user_manager');
        $request = $this->getRequest();

        if(!$project = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->findOneById($id)) {
            throw $this->createNotFoundException('The project does not exist');
        }

        if(!$this->get('acl_helper')->canEdit($project)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ProjectDescriptionType(), $project);
        $tags = $project->getTags();
        $t[] = null;
        foreach($tags as $tag) {
            $t[] = $tag->getName();
        }
        $tag_list = implode(',', $t);

        if($request->getMethod() == "GET") {
            return $this->render('GCDashboardBundle:Project:edit.html.twig', 
                array(  "phase" => 0,
                        "form" => $form->createView(), 
                        "tag_list" => $tag_list, 
                        "id" => $project->getId(),
                        'session' => array(
                            'name' => ini_get('session.name'),
                            'id' => session_id(),
                        ),                      
                        "assets" => $project->getAssets()));

        } else if($request->getMethod() == "POST") {
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
                $progress->setPhase($phase+1);
                $em->persist($progress);
                $em->flush();   
                return $this->redirect($this->generateUrl('project_package'));
            } else {
                return $this->render('GCDashboardBundle:project_brief.html.twig', 
                    array(  "phase" => $phase,
                            "form" => $form->createView(), 
                            "tag_list" => $tag_list, 
                            "id" => $project_id,
                            "assets" => $project->getAssets()));            
            }
        }        
    }
}
