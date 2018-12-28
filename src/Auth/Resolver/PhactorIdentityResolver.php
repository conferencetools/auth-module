<?php


namespace ConferenceTools\Authentication\Auth\Resolver;

use ConferenceTools\Authentication\Auth\Credential\Identity as IdentityCredential;
use ConferenceTools\Authentication\Auth\Exception\CantResolve;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Phactor\ReadModel\Repository;

class PhactorIdentityResolver implements IdentityResolver
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function resolve(IdentityCredential $credentials)
    {
        /** @var User $user */
        $user = $this->repository->get($credentials->getIdentity());

        if (!($user instanceof User)) {
            throw new CantResolve();
        }

        return $user;
    }
}