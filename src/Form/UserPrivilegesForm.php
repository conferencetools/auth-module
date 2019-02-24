<?php

namespace ConferenceTools\Authentication\Form;

use Zend\Form\Element\Csrf;
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

        $this->add(new Csrf('security'));
        $this->add(new Submit('update', ['label' => 'Update']));
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