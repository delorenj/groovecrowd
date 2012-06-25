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
   public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $userRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:User');      
        $projects = $userRepo->findAllActiveProjects($user);
        $now = time();
        foreach($projects as $p) {            
            $then = strtotime($p->getExpiresAt()->format('Y-m-d H:i:s'));
            $datediff = $then - $now;
            $p->secondsRemaining = $datediff;
            $p->percentComplete = 100-($p->secondsRemaining/($p->getContestLength()*60*60*24))*100;
            $p->payoutAmount = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->getPayoutAmount($p); //REFACTOR 
            $p->grooveCount = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->getGrooveCount($p); //REFACTOR
        }

        if($this->getRequest()->isXmlHttpRequest()) {
            $this->get('logger')->info('Ajax Request');
            $projectArray = array();
            foreach($projects as $p) {
                $projectArray[] = $p->toArray();
            }
            return new Response(json_encode($projectArray), 200);
        } elseif (count($projects) == 1) {  
        $this->get('logger')->info('here');          
            return $this->render('GCDashboardBundle:Project:show.html.twig', array("project" => $projects[0]));
        } else {
            return $this->render('GCDashboardBundle:Project:index.html.twig', array("projects" => $projects));
        }
    }

    public function showAction() {
        return $this->render('GCDashboardBundle:Project:show.html.twig');
    }
}
