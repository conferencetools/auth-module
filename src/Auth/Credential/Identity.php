<?php


namespace ConferenceTools\Authentication\Auth\Credential;


final class Identity
{
    private $identity;

    public function __construct(string $identity)
    {
        $this->identity = $identity;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }
}