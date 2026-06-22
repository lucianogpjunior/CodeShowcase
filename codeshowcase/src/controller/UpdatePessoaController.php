<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\UserEntity;
use App\DAO\UserDAO;

if (!isset($_POST['id']) || !is_number(['id'])) {
    header('Location: ../index.php');
    exit;
}

$dao = new UserDAO;
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

$dao->update($p);

header('Location: ../index.php');
exit;
