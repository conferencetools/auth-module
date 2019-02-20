<?php

namespace ConferenceTools\Authentication\Domain\User\Command;

use ConferenceTools\Authentication\Domain\User\HashedPassword;

class ChangeUserPassword
{
    private $username;
    private $password;

    public function __construct(string $username, HashedPassword $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): HashedPassword
    {
        return $this->password;
    }
}