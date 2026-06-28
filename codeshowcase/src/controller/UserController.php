<?php
namespace App\controller;

use App\models\UserEntity;
use App\dao\UserDAO;

class UserController {
    public function createUser(){

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $dtNascimento = $_POST['dtNascimento'] ?? '';
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        if (
            empty($nome) ||
            empty($email) ||
            empty($dtNascimento) ||
            empty($cpf) ||
            empty($senha)
        ) {
            die("Todos os campos são obrigatórios.");
        };

        $user = new UserEntity(
            null,
            $nome, 
            $email, 
            $dtNascimento, 
            $cpf, 
            $senha,
            date('Y-m-d H:i:s')
        );

        $userDAO = new UserDAO();
        $userDAO->create($user);

        header('Location: /home');
        exit;
    }
}
?>