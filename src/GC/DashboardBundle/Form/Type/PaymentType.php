<?php

namespace GC\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class PaymentType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('first_name', 'text', array(
			"required" => true)		
		);

		$builder->add('last_name', 'text', array(
			"required" => true)		
		);

		$builder->add('address1', 'text', array(
			"required" => true)		
		);		

		$builder->add('address2', 'text', array(
			"required" => false)		
		);		

		$builder->add('city', 'text', array(
			"required" => true)		
		);

		$builder->add('state', 'choice', array(
			"choices" => array(
				"NJ" => "New Jersey",
				"PA" => "Pennsylvania"
				),
			"required" => true,
			"multiple" => false,
			"expanded" => false)
		);		

		$builder->add('zip', 'text', array(
			"required" => true)		
		);

		$builder->add('email', 'email', array(
			"required" => true)		
		);		

		$builder->add('plain_password', 'password', array(
			"required" => true)		
		);		

		$builder->add('phone', 'text', array(
			"required" => false)		
		);		
	}

	public function getName() {
		return 'payment';
	}

	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'GC\DataLayerBundle\Entity\User'
		);
	}
}