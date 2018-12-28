<?php


namespace ConferenceTools\Authentication\Auth\Authenticator;


use ConferenceTools\Authentication\Auth\Extractor\UsernameAndPasswordExtractor;
use ConferenceTools\Authentication\Auth\Identity;
use ConferenceTools\Authentication\Auth\Resolver\UsernameAndPasswordResolver;
use Zend\Http\Request;

class UsernameAndPasswordAuthenticator implements Authenticator
{
    private $extractor;
    private $resolver;

    public function __construct(UsernameAndPasswordExtractor $extractor, UsernameAndPasswordResolver $resolver)
    {
        $this->extractor = $extractor;
        $this->resolver = $resolver;
    }

    public function authenticate(Request $request): ?Identity
    {
        $credentials = $this->extractor->extract($request);
        return new Identity($credentials->getUsername(), $this->resolver->resolve($credentials));
    }
}