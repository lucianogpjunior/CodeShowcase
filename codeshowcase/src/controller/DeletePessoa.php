<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\UserEntity;
use App\DAO\UserDAO;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../index.php');
    exit;
}

$id  = (int) $_GET['id'];
$dao = new UserDAO(conexao::getConexao());
$dao->delete($id);

header('Location: ../index.php');
exit;