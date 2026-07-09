<?php

namespace App\Controller;

class HomeController
{
    public function index()
    {
        require __DIR__ . '/../Views/Home.php';
    }

    public function redirectHome(){
        header('Location: /home');
        exit;
    }
}