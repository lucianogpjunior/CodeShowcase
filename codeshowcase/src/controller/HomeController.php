<?php

namespace App\controller;

class HomeController
{
    public function index()
    {
        require __DIR__ . '/../views/home.php';
    }
}