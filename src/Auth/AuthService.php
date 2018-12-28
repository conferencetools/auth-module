<?php


namespace ConferenceTools\Authentication\Auth;


use ConferenceTools\Authentication\Auth\Exception\AuthenticationFailed;
use ConferenceTools\Authentication\Auth\Exception\CantAuthenticate;
use ConferenceTools\Authentication\Auth\Exception\CantExtract;
use ConferenceTools\Authentication\Auth\Exception\CantResolve;
use ConferenceTools\Authentication\Auth\Persistor\Persistor;
use Zend\Http\Request;
use Zend\Http\Response;

class AuthService
{
    /**
     * @var Authenticator\Authenticator[]
     */
    private $authenticators;
    private $identity;
    private $hasAuthenticated = false;
    private $persistor;

    public function __construct(Persistor $persistor, Authenticator\Authenticator ...$authenticators)
    {
        $this->authenticators = $authenticators;
        $this->persistor = $persistor;
    }

    public function getIdentity(Request $request): ?Identity
    {
        if ($this->hasAuthenticated) {
            return $this->identity;
        }

        $this->hasAuthenticated = true;
        $authenticationFailed = false;

        try {
            foreach ($this->authenticators as $authenticator) {
                try {
                    $identity = $authenticator->authenticate($request);
                    if ($identity instanceof Identity) {
                        $this->identity = $identity;
                        return $identity;
                    }
                } catch (CantExtract $e) {
                    null; //move onto next authenticator
                } catch (CantResolve $e) {
                    $authenticationFailed = true;
                }
            }
        } catch (CantAuthenticate $e) {
            $authenticationFailed = true;
        }

        if ($authenticationFailed) {
            throw new AuthenticationFailed();
        }

        return null; //no credentials available
    }

    public function persistIdentity(Response $response): void
    {
        if ($this->hasAuthenticated && $this->identity !== null) {
            $this->persistor->persistIdentity($response, $this->identity);
        }
    }

    public function clearIdentity(): void
    {
        $this->identity = null;
    }
}