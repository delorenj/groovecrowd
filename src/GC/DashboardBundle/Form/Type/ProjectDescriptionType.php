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
		$builder->add('expires_at', 'choice', array(
			"choices" => array(
				1 => '1-Day Contest',
				3 => '3-Day Contest',
				7 => '7-Day Contest',
				15 => '15-Day Contest'),
			"label" => "Contest Length",
			"expanded" => true,
			"multiple" => false));

    	$builder->add('tag_list', null, array(
    		'property_path' => false,
    		'label' => "Tags"));
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