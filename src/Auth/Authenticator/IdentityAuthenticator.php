<?php


namespace ConferenceTools\Authentication\Auth\Authenticator;


use ConferenceTools\Authentication\Auth\Extractor\IdentityExtractor;
use ConferenceTools\Authentication\Auth\Identity;
use ConferenceTools\Authentication\Auth\Resolver\IdentityResolver;
use Zend\Http\Request;

class IdentityAuthenticator implements Authenticator
{
    private $extractor;
    private $resolver;

    public function __construct(IdentityExtractor $extractor, IdentityResolver $resolver)
    {
        $this->extractor = $extractor;
        $this->resolver = $resolver;
    }

    public function authenticate(Request $request): ?Identity
    {
        $credentials = $this->extractor->extract($request);
        return new Identity($credentials->getIdentity(), $this->resolver->resolve($credentials));
    }
}