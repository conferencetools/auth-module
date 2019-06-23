<?php

namespace ConferenceTools\Authentication\Form;

use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class UserPrivilegesForm extends Form implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'type' => MultiCheckbox::class,
            'name' => 'permissions',
            'options' => [
                'label' => 'Permissions',
                'value_options' => $this->getOption('permissions')
            ],
        ]);

        $this->add([
            'type' => Submit::class,
            'name' => 'update',
            'options' => [
                'label' => 'Update',
            ],
            'attributes' => [
                'class'=> 'btn-primary',
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'permissions' => [
                'allow_empty' => true,
                'required' => false,
            ],
        ];
    }
}