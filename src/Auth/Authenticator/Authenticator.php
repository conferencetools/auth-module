<?php


namespace ConferenceTools\Authentication\Auth\Authenticator;


use ConferenceTools\Authentication\Auth\Identity;
use Zend\Http\Request;

interface Authenticator
{
    public function authenticate(Request $request): ?Identity;
}