<?php

namespace ConferenceTools\Authentication\Domain\User\ReadModel;

use ConferenceTools\Authentication\Domain\User\HashedPassword;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @ORM\Id @ORM\Column(type="string")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    public function __construct(string $id, string $username, HashedPassword $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password->getHash();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
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

}