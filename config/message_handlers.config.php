<?php

use ConferenceTools\Attendance\Domain\Ticketing;
use ConferenceTools\Attendance\Domain\Purchasing;
use ConferenceTools\Attendance\Domain\Delegate;
use ConferenceTools\Attendance\Factory;

return [
    'factories' => [
        \ConferenceTools\Authentication\Domain\User\Projector::class => \ConferenceTools\Authentication\Factory\UserProjectorFactory::class
    ]
];