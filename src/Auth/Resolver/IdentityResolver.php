<?php


namespace ConferenceTools\Authentication\Auth\Resolver;


use ConferenceTools\Authentication\Auth\Credential\Identity as IdentityCredential;

interface IdentityResolver
{
    public function resolve(IdentityCredential $credentials);
}