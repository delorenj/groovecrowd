<?php

namespace GC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DashboardController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('GCUserBundle:Dashboard:index.html.twig');
    }

    public function testAction() 
    {
		$u = $this->get('security.context')->getToken()->getUser();
    	$u->addRole("TEST");
    	return $this->render('GCUserBundle:Dashboard:test.html.twig');
    }
}
