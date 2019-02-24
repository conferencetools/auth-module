<?php
return [
    'default' => [
        [
            'label' => 'Users',
            'route' => 'authentication/users',
            'permission' => 'user-management',
            'pages' => [
                [
                    'label' => 'Add user',
                    'route' => 'authentication/users/new',
                ]
            ],
        ],
        [
            'label' => 'Account',
            'route' => 'attendance-admin',
            'pages' => [
                [
                    'label' => 'Change password',
                    'route' => 'authentication/account/change-password',
                ]
            ],
        ]
    ],
];