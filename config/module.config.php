<?php

return [
    'auth' => [
        'signingKey' => 'GsPCjwFXRTHjDQ6/+hw1wQuatjNBMqYN/foH2W0dD7E=',
        'loginTimeout' => 30*60,
        'cookieOptions' => [
            'secure' => false
        ],
    ],
    'controllers' => require __DIR__ . '/controllers.config.php',
    'controller_plugins' => [
        'factories' => [
            'identity' => \ConferenceTools\Authentication\Mvc\Controller\Plugin\IdentityFactory::class,
        ],
    ],
    'doctrine' => require __DIR__ . '/doctrine.config.php',
    'navigation' => require __DIR__ . '/navigation.config.php',
    'message_handlers' => require __DIR__ . '/message_handlers.config.php',
    'message_subscription_providers' => [\ConferenceTools\Authentication\Domain\MessageSubscriptions::class],
    'router' => [
        'routes' => require __DIR__ . '/routes.config.php',
    ],
    'service_manager' =>[
        'factories' => [
            \ConferenceTools\Authentication\Auth\AuthService::class => \ConferenceTools\Authentication\Auth\Factory::class,
        ],
    ],
    'view_manager' => [
        'controller_map' => [
            'ConferenceTools\Authentication\Controller' => 'auth',
        ],
        'template_map' => require __DIR__ . '/views.config.php',
    ],
];