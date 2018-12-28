<?php

use ConferenceTools\Authentication\Controller;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'factories' => [
        Controller\AuthController::class => InvokableFactory::class,
    ]
];