<?php

namespace GC\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class PackageSelectionType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('package', 'hidden');
		$builder->add('blind', 'checkbox', array(
			"label" => "Make it a blind contest",
			"required" => false)
		);
		$builder->add('payout_guaranteed', 'checkbox', array(
			"label" => "Guarantee a Winner",
			"required" => false)
		);		
		$builder->add('protection', 'checkbox', array(
			"label" => "Add copy protection to all uploaded entries",
			"required" => false,
			"property_path" => false)
		);		
	}

	public function getName() {
		return 'packageSelection';
	}

	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'GC\DataLayerBundle\Entity\Project'
		);
	}
}