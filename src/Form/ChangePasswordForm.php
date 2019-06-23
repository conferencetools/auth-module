<?php


namespace ConferenceTools\Authentication\Form;


use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;

class ChangePasswordForm extends Form implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'type' => Password::class,
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);


        $this->add([
            'type' => Password::class,
            'name' => 'confirm',
            'options' => [
                'label' => 'Confirm password',
            ],
        ]);

        $this->add(new Submit('create', ['label' => 'Create']));
    }

    public function getInputFilterSpecification()
    {
        return [
            'password' => [
                'allow_empty' => false,
                'required' => true,
                'validators' => [
                    ['name' => NotEmpty::class],
                ]
            ],
            'confirm' => [
                'allow_empty' => false,
                'required' => true,
                'validators' => [
                    ['name' => NotEmpty::class],
                    ['name' => Identical::class, 'options' => ['token' => 'password']],
                ]
            ],
        ];
    }
}