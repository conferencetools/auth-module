<?php


namespace ConferenceTools\Authentication\Domain\User;


class HashedPassword
{
    private $hash;

    public function __construct(string $password)
    {
        $this->hash = \password_hash($password, \PASSWORD_DEFAULT);
    }

    public static function fromHash(string $hash)
    {
        if (substr_count($hash, '$') < 3) {
            throw new \Exception('That doesnt look like a password hash.');
        }

        $instance = new self('');
        $instance->hash = $hash;
        return $instance;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}