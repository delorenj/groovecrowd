<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GC\DataLayerBundle\Entity\User;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectType;
use GC\DataLayerBundle\Entity\ProjectCreationProgress;
use GC\DataLayerBundle\Entity\ProjectAsset;
use GC\DataLayerBundle\Helpers;
use GC\DashboardBundle\Form\Type\ProjectDescriptionType;
use GC\DashboardBundle\Form\Type\PackageSelectionType;
use GC\DashboardBundle\Form\Type\PaymentType;

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
            foreach($projects as $p) {
                $projectArray[] = $p->toArray();
            }
            return new Response(json_encode($projectArray), 200);
        } else {
            return $this->render('GCDashboardBundle:Project:index.html.twig', array("projects" => $projects));
        }
    }

    public function showAction($id) {
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');      
        $p = $projectRepo->find($id);
        return $this->render('GCDashboardBundle:Project:show.html.twig', array("project" => $p));
    }
}
