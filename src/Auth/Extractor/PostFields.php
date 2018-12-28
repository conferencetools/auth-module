<?php


namespace ConferenceTools\Authentication\Auth\Extractor;


use ConferenceTools\Authentication\Auth\Credential\UsernameAndPassword;
use ConferenceTools\Authentication\Auth\Exception\CantExtract;
use Zend\Http\Request;

class PostFields implements UsernameAndPasswordExtractor
{
    private $usernameField;
    private $passwordField;

    public function __construct(string $usernameField = 'username', string $passwordField = 'password')
    {
        $this->usernameField = $usernameField;
        $this->passwordField = $passwordField;
    }

    public function extract(Request $request): UsernameAndPassword
    {
        $postData = $request->getPost();

        if (!isset($postData[$this->usernameField], $postData[$this->passwordField])) {
            throw new CantExtract();
        }

        return new UsernameAndPassword($postData[$this->usernameField], $postData[$this->passwordField]);
    }
}