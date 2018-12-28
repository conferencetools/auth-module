<?php

use Zend\Router\Http\Literal;
use Zend\Router\Http\Placeholder;
use ConferenceTools\Authentication\Controller;

return [
    'authentication' => [
        'type' => Placeholder::class,
        'child_routes' => [
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'=> 'auth'
                    ]
                ],
                'may_terminate' => true,
            ]
        ]
    ]
];