<?php
use App\controller\UserController;

$router->post(
    '/cadastro-user',
    [
        UserController::class,
        'createUser'
    ]
);
?>