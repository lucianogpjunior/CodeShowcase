<?php
use App\controller\HomeController;
use App\controller\UserController;

$router->get(
    '/',
    [
        HomeController::class,
        'redirectHome'
    ]
);

$router->get(
    '/home',
    [
        HomeController::class,
        'index'
    ]
);

$router->get(
    '/cadastro',
    [
        UserController::class,
        'cadastroView'
    ]
);
?>