<?php


namespace ConferenceTools\Authentication\Auth\Extractor;


use ConferenceTools\Authentication\Auth\Credential\UsernameAndPassword;
use Zend\Http\Request;

interface UsernameAndPasswordExtractor extends Extractor
{
    public function extract(Request $request): UsernameAndPassword;
}