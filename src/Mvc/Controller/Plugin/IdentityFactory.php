<?php


namespace ConferenceTools\Authentication\Mvc\Controller\Plugin;


use ConferenceTools\Authentication\Auth\AuthService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class IdentityFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Identity($container->get(AuthService::class));
    }
}