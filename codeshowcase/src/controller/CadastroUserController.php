<?php
namespace App\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\UserEntity;
use App\DAO\UserDAO;


$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email']);
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

$CreateUser = new UserDAO();
$CreateUser->create($user);

header('Location: ../index.php');
exit;
?>