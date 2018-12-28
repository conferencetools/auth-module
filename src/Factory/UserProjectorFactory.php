<?php

namespace ConferenceTools\Authentication\Factory;

use ConferenceTools\Authentication\Domain\User\Projector;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Interop\Container\ContainerInterface;
use Phactor\Identity\Generator;
use Phactor\Zend\RepositoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserProjectorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repositoryManager = $container->get(RepositoryManager::class);
        $repository = $repositoryManager->get(User::class);
        return new Projector($repository, $container->get(Generator::class));
    }
}
