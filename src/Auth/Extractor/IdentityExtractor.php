<?php


namespace ConferenceTools\Authentication\Auth\Extractor;


use ConferenceTools\Authentication\Auth\Credential\Identity as IdentityCredential;
use Zend\Http\Request;

interface IdentityExtractor extends Extractor
{
    public function extract(Request $request): IdentityCredential;
}