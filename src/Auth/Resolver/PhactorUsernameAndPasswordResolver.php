<?php


namespace ConferenceTools\Authentication\Auth\Resolver;

use ConferenceTools\Authentication\Auth\Credential\UsernameAndPassword;
use ConferenceTools\Authentication\Auth\Exception\CantAuthenticate;
use ConferenceTools\Authentication\Auth\Exception\CantResolve;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Doctrine\Common\Collections\Criteria;
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
        $user = $this->repository->matching(Criteria::create()->where(Criteria::expr()->eq('username', $credentials->getUsername())))->current();

        if (!($user instanceof User)) {
            throw new CantResolve();
        }

        if ($user->comparePassword($credentials->getPassword())) {
            return $user;
        }

        throw new CantAuthenticate();
    }
}