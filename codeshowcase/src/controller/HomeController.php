<?php

namespace App\controller;

class HomeController
{
    public function index()
    {
        require __DIR__ . '/../views/home.php';
    }

    public function redirectHome(){
        header('Location: /home').
        exit;
    }
}