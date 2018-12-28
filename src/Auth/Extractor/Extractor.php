<?php


namespace ConferenceTools\Authentication\Auth\Extractor;


use Zend\Http\Request;

interface Extractor
{
    public function extract(Request $request);
}