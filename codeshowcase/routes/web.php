<?php

// CORRIGIDO: namespaces padronizados para PascalCase (PSR-4)
use App\Controller\HomeController;
use App\Controller\UserController;

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