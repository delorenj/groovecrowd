<?php

namespace GC\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class WelcomeController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('GCWelcomeBundle:Welcome:index.html.twig');
    }
}
