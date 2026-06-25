<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\HomeController;
use App\Controller\UserController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
//Pages
    case '/home':
        $controller = new HomeController();
        $controller->index();
        break;
    case '/cadastro':
        include __DIR__ . '/../src/views/cadastroUserView.php';
        break;
//Actions
    case '/create-user':
        $controller = new UserController();
        $controller->createUser();
        break;
    default:
        http_response_code(404);
        echo "<h1>Página não encontrada</h1>";
}