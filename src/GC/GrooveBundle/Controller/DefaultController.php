<?php

namespace GC\GrooveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('GCGrooveBundle:Default:index.html.twig', array('name' => $name));
    }
}
