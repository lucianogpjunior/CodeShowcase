<?php

namespace App\Controller;

class HomeController
{
    public function index()
    {
        require __DIR__ . '/../views/home.php';
    }
}