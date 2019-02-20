<?php
$viewDir = __DIR__ . '/../view/';
return [
    'auth/layout' => $viewDir . 'layout.phtml',
    'auth/auth/auth' => $viewDir . 'login.phtml',
    'auth/user/add-user' => $viewDir . 'user/add-user.phtml',
    'auth/user/change-password' => $viewDir . 'user/change-password.phtml',
    'auth/user/index' => $viewDir . 'user/index.phtml',
];