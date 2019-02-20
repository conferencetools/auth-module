<?php

namespace ConferenceTools\Authentication\Domain\User\ReadModel;

use ConferenceTools\Authentication\Domain\User\HashedPassword;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /** @ORM\Id @ORM\Column(type="string") */
    private $username;
    /** @ORM\Column(type="string") */
    private $password;
    /** @ORM\Column(type="boolean", options={"default" : true}) */
    private $forcePasswordChange = true;

    public function __construct(string $username, HashedPassword $password)
    {
        $this->username = $username;
        $this->password = $password->getHash();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function comparePassword(string $password): bool
    {
        $result = \password_verify($password, $this->password);

        if ($result && \password_needs_rehash($this->password, \PASSWORD_DEFAULT)) {
            $hash = new HashedPassword($password);
            $this->password = $hash->getHash();
        }

        return $result;
    }

    public function changePassword(HashedPassword $password): void
    {
        $this->password = $password->getHash();
        $this->forcePasswordChange = false;
    }

    public function mustChangePassword(): bool
    {
        return $this->forcePasswordChange;
    }
}