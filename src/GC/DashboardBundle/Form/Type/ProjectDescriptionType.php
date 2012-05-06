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
		$builder->add('expires_at', 'hidden');
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