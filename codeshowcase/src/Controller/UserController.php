<?php

namespace App\Controller;

use App\Models\UserEntity;
use App\DAO\UserDAO;

require_once __DIR__ . '/../../vendor/autoload.php';

class UserController {

    // Métodos de view
    public function cadastroView() {
        require __DIR__ . '/../Views/cadastroUserView.php';
    }

    // Métodos de usuário
    public function createUser() {

        $nomeUsuario  = trim($_POST['nome_usuario'] ?? '');
        $nome         = trim($_POST['nome'] ?? '');
        $email        = trim($_POST['email'] ?? '');
        $dtNascimento = $_POST['dtNascimento'] ?? '';
        $cpf          = $_POST['cpf'] ?? '';
        $senha        = $_POST['senha'] ?? '';

        if (
            empty($nomeUsuario) ||
            empty($nome) ||
            empty($email) ||
            empty($dtNascimento) ||
            empty($cpf) ||
            empty($senha)
        ) {
            die("Todos os campos são obrigatórios.");
        }

        $user = new UserEntity(
            null,
            $nomeUsuario,
            $nome,
            $email,
            $senha,
            $dtNascimento,
            $cpf,
            date('Y-m-d H:i:s'),
            true
        );

        $userDAO = new UserDAO();
        $userDAO->create($user);

        header('Location: /home');
        exit;
    }

    public function deleteUser() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: ../index.php');
            exit;
        }

        $id  = (int) $_GET['id'];
        $dao = new UserDAO();
        $dao->delete($id);

        header('Location: ../index.php');
        exit;
    }

    public function updateUser() {
        // CORRIGIDO: era is_numeric(['id']) — array literal em vez de $_POST['id']
        // isso fazia a validação nunca funcionar corretamente
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            header('Location: ../index.php');
            exit;
        }

        $dao  = new UserDAO();
        $user = $dao->read((int) $_POST['id']);

        if (!$user) {
            header('Location: ../index.php');
            exit;
        }

        $user->setNomeCompleto($_POST['nome']);
        $user->setEmail($_POST['email']);
        $user->setDataNascimento($_POST['dtNascimento']);
        $user->setCpf($_POST['cpf']);
        $user->setSenha($_POST['senha']);

        $dao->update($user);

        header('Location: ../index.php');
        exit;
    }
}
?>