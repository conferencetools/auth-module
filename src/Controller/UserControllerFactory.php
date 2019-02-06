<?php

namespace ConferenceTools\Authentication\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserController($container->get('Zend\Form\FormElementManager'));
    }
}
