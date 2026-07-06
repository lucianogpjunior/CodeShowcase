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
$router->post(
    '/projetos/cadastrar',
     [
        ProjectController::class,
         'createProject'
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
$router->post(
    '/projetos/atualizar',
     [
        ProjectController::class,
         'updateProject'
    ]
);
 
// Deleção
$router->get(
    '/projetos/deletar',
     [
        ProjectController::class,
         'deleteProject'
    ]
);

$router->get(
    '/projetos/desativar',
     [
        ProjectController::class,
         'desativarProject'
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
    '/projetos/pagamento',
    [
        ProjectController::class,
        'pagamentoView'
    ]
);

$router->post(
    '/comprar/processar',
    [
        ProjectController::class,
        'processarPagamento'
    ]
);

$router->get(
    '/comprar/sucesso',
    [
        ProjectController::class,
        'sucessoView'
    ]
);
