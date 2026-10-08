<?php

namespace App\Config;

class Router
{
    private array $routes = [];

    public function get($uri,$callback)
    {
        $this->routes['GET'][$uri]
            = $callback;
    }

    public function post($uri,$callback)
    {
        $this->routes['POST'][$uri]
            = $callback;
    }

    public function dispatch(
        $uri,
        $method
    )
    {
        if(
            !isset(
                $this->routes[$method][$uri]
            )
        ){
            die('404');
        }

        [$class,$function]
            = $this->routes[$method][$uri];

        $controller = new $class();

        $controller->$function();
    }
}