<?php

namespace GC\DataLayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('GCDataLayerBundle:Default:index.html.twig', array('name' => $name));
    }
}
