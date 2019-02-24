<?php

namespace ConferenceTools\Authentication\Domain\User\Command;

class ChangeUserPermissions
{
    private $username;
    private $permissions;

    public function __construct(string $username, array $permissions)
    {
        $this->username = $username;
        $this->permissions = $permissions;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}