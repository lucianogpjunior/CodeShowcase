<?php

// CORRIGIDO: namespaces padronizados para PascalCase (PSR-4)
use App\Controller\HomeController;
use App\Controller\UserController;
use App\Controller\ProjectController;

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

$router->get(
    '/login',
    [
        UserController::class,
        'loginView'
    ]
);

$router->get(
    '/dev/cadastro',
    [
        UserController::class,
        'devCadastroView'
    ]
);

// Listagem pública
$router->get(
    '/projetos', 
    [
        ProjectController::class,
         'index'
    ]
);
 
// Cadastro
$router->get(
    '/projetos/cadastro',
     [
        ProjectController::class,
         'cadastroView'
    ]
);
 
// Edição
$router->get(
    '/projetos/editar',
     [
        ProjectController::class,
         'editView'
    ]
);

$router->get(
    '/projetos/comprar',
    [
        ProjectController::class,
        'comprarView'
    ]
);

$router->get(
    '/comprar/sucesso',
    [
        ProjectController::class,
        'sucessoView'
    ]
);
