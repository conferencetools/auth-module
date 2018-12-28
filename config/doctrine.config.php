<?php
return [
    'driver' => [
        'user' => [
            'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
            'cache' => 'array',
            'paths' => [__DIR__ . '/../src/Domain/User']
        ],
        'orm_default' => [
            'drivers' => [
                'ConferenceTools\\Authentication\\Domain\\User' => 'user',
            ]
        ]
    ],
];
