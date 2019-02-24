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
            ],
            'users' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/users',
                    'defaults' => [
                        'requiresAuth' => true,
                        'requiresPermission' => 'user-management',
                        'layout' => 'attendance/admin-layout', // @TODO this is a dependency in another module.
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'new' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/new',
                            'defaults' => [
                                'action' => 'add-user',
                            ]
                        ]
                    ],
                    'permissions' => [
                        'type' => \Zend\Router\Http\Segment::class,
                        'options' => [
                            'route' => '/:user/permissions',
                            'defaults' => [
                                'action' => 'update-permissions',
                            ]
                        ]
                    ],
                ]
            ],
            'account' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/account',
                    'defaults' => [
                        'requiresAuth' => true,
                        'layout' => 'attendance/admin-layout', // @TODO this is a dependency in another module.
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'change-password' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/change-password',
                            'defaults' => [
                                'action' => 'change-password',
                            ]
                        ]
                    ],
                ],
            ],
        ]
    ]
];