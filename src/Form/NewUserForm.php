<?php


namespace ConferenceTools\Authentication\Form;


use Zend\Form\Element\Csrf;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class NewUserForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => Text::class,
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
        ]);


        $this->add([
            'type' => Password::class,
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add(new Csrf('security'));
        $this->add(new Submit('create', ['label' => 'Create']));
    }
}