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

    	$builder->add('media_upload', "file", array(
    		'property_path' => false,
    		'required' => false,
    		'label' => "Upload Media"));

    	$builder->add('web_upload', "url", array(
    		'property_path' => false,
    		'required' => false,
    		'label' => "Link"));
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