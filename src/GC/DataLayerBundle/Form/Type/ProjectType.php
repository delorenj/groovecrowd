<?php

namespace GC\DataLayerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProjectType extends AbstractType
{
    private $projectTypes;

    public function __construct()
    {
        $this->projectTypes = array(
            "1" => "test1", 
            "2" => "test2");
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'choices' => $this->projectTypes,
        );
    }

    public function getParent(array $options) {
        return 'choice';
    }

    public function getName() {
        return 'projectType';
    }

}