<?php

namespace GC\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GC\DataLayerBundle\Entity\Category;

class CategoryController extends Controller {

	public function indexAction() {
		$em = $this->get('doctrine')->getEntityManager()->getRepository('GCDataLayerBundle:Category');
		$cats = $em->getSubtree("root");
		return $this->render('GCProjectBundle:Category:index.html.twig', array("cats" => $cats));
	}

	public function addAction(Request $request) {
		$em = $this->get('doctrine')->getEntityManager()->getRepository('GCDataLayerBundle:Category');
		$existing_cats = $em->findAll();
		$cat_names[] = "Root";
		// foreach ($existing_cats as $x) {
		// 	$cat_names[] = $x->getName();
		// }

		$cat = new Category();

		//create form and bind it
		$form = $this->createFormBuilder($cat)
			->add('name', 'text')
			->add('parent_id', 'choice', array(
			    	'choices'   => array('m' => 'Male', 'f' => 'Female'),
				)
			)
			->getForm();

		return $this->render('GCProjectBundle:Category:add.html.twig', array(
			'form' => $form->createView()));

	}
}