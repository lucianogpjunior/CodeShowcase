<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Config\Router;

$router = new Router();

require '../routes/web.php';
require '../routes/api.php';

$router->dispatch(
    parse_url(
        $_SERVER['REQUEST_URI'],
        PHP_URL_PATH
    ),
    $_SERVER['REQUEST_METHOD']
);
?>