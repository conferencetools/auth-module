<?php


namespace ConferenceTools\Authentication\Auth\Resolver;

use ConferenceTools\Authentication\Auth\Credential\UsernameAndPassword;
use ConferenceTools\Authentication\Auth\Exception\CantAuthenticate;
use ConferenceTools\Authentication\Auth\Exception\CantResolve;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Phactor\ReadModel\Repository;

class PhactorUsernameAndPasswordResolver implements UsernameAndPasswordResolver
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function resolve(UsernameAndPassword $credentials)
    {
        $user = $this->repository->get($credentials->getUsername());

        if (!($user instanceof User)) {
            throw new CantResolve();
        }

        if ($user->comparePassword($credentials->getPassword())) {
            return $user;
        }

        throw new CantAuthenticate();
    }
}