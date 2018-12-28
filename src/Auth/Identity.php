<?php


namespace ConferenceTools\Authentication\Auth;


class Identity
{
    private $identityData;
    private $identifier;

    public function __construct($identifier, $identityData)
    {
        $this->identityData = $identityData;
        $this->identifier = $identifier;
    }

    public function getIdentityData()
    {
        return $this->identityData;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}