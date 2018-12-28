<?php


namespace ConferenceTools\Authentication\Domain\User;


class HashedPassword
{
    private $hash;

    public function __construct(string $password)
    {
        $this->hash = \password_hash($password, \PASSWORD_DEFAULT);
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}