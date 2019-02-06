<?php


namespace ConferenceTools\Authentication\Auth\Extractor;


use ConferenceTools\Authentication\Auth\Credential\Identity as IdentityCredential;
use ConferenceTools\Authentication\Auth\Exception\CantExtract;
use ConferenceTools\Authentication\Auth\Identity;
use ConferenceTools\Authentication\Auth\Persistor\Persistor;
use ParagonIE\Paseto\Builder;
use ParagonIE\Paseto\JsonToken;
use ParagonIE\Paseto\Keys\SymmetricKey;
use ParagonIE\Paseto\Parser;
use ParagonIE\Paseto\Rules\NotExpired;
use Zend\Http\Header\Cookie;
use Zend\Http\Header\SetCookie;
use Zend\Http\Request;
use Zend\Http\Response;

class PasetoCookie implements IdentityExtractor, Persistor
{
    const COOKIE_NAME = 'auth';
    const CLAIM_NAME = 'identity';

    private $parser;
    private $builder;
    private $loginTimeout;
    private $cookieOptions = [
        'path' => '/',
        'domain' => null,
        'secure' => true,
    ];

    public function __construct(Parser $parser, Builder $builder, int $loginTimeout, array $cookieOptions)
    {
        $this->parser = $parser;
        $this->builder = $builder;
        $this->loginTimeout = $loginTimeout;
        $this->cookieOptions = array_merge($this->cookieOptions, $cookieOptions);
    }

    public function extract(Request $request): IdentityCredential
    {
        $cookie = $request->getCookie();
        if (!($cookie instanceof Cookie)) {
            throw new CantExtract();
        }

        if (!isset($cookie[self::COOKIE_NAME])) {
            throw new CantExtract();
        }

        $token = $this->parser->parse($cookie[self::COOKIE_NAME]);
        $identity = $token->get(self::CLAIM_NAME);

        return new IdentityCredential($identity);
    }

    public function persistIdentity(Response $response, Identity $identity): void
    {
        $identity = $identity->getIdentifier();
        $expiry = (new \DateTime())->add(new \DateInterval(sprintf('PT%dS', $this->loginTimeout)));
        $token = (new JsonToken())->withExpiration($expiry)->with(self::CLAIM_NAME, $identity);
        $token = $this->builder->withJsonToken($token);

        $cookie = new SetCookie(
            self::COOKIE_NAME,
            $token->toString(),
            $expiry,
            $this->cookieOptions['path'], //path
            $this->cookieOptions['domain'], // domain
            $this->cookieOptions['secure'], //secure
            true // httponly
        );

        $response->getHeaders()->addHeader($cookie);
    }
}