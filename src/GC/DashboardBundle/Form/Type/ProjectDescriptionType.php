<?php

namespace GC\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class ProjectDescriptionType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('title');
		$builder->add('description');
		$builder->add('contest_length', 'choice', array(
			"choices" => array(
				1 => '1-Day Contest',
				3 => '3-Day Contest',
				7 => '7-Day Contest',
				15 => '15-Day Contest'),
			"label" => "Contest Length",
			"expanded" => false,
			"multiple" => false));

    	$builder->add('tag_list', null, array(
    		'property_path' => false,
    		'required' => false,
    		'label' => "Tags"));

    	$builder->add('web_upload', "url", array(
    		'property_path' => false,
    		'required' => false,
    		'label' => "URL"));

    	$builder->add('web_upload_description', "textarea", array(
    		'property_path' => false,
    		'required' => false,
    		'label' => "Description"));

	}

	public function getName() {
		return 'projectDescription';
	}

	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'GC\DataLayerBundle\Entity\Project'
		);
	}
}