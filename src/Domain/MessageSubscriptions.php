<?php

namespace ConferenceTools\Authentication\Domain;


use ConferenceTools\Authentication\Domain\User\Projector;

class MessageSubscriptions
{
    public static function getSubscriptions()
    {
        return [
            User\Command\CreateNewUser::class => [
                Projector::class,
            ],
            User\Command\ChangeUserPassword::class => [
                Projector::class,
            ],
        ];
    }
}