<?php

namespace GC\DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class TagType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('name');
	}

	public function getName() {
		return 'tag';
	}

	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'GC\DataLayerBundle\Entity\Tag'
		);
	}
}