<?php

namespace ConferenceTools\Authentication\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return new UserController($container->get('Zend\Form\FormElementManager'), $config['auth']['permissions']);
    }
}
