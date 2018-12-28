<?php

namespace ConferenceTools\Authentication\Auth\Persistor;

use ConferenceTools\Authentication\Auth\Identity;
use Zend\Http\Response;

interface Persistor
{
    public function persistIdentity(Response $response, Identity $identity);
}