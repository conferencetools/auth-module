<?php


namespace ConferenceTools\Authentication\Auth\Resolver;


use ConferenceTools\Authentication\Auth\Credential\UsernameAndPassword;

interface UsernameAndPasswordResolver
{
    public function resolve(UsernameAndPassword $credentials);
}