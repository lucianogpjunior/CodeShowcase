<?php
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../models/UserEntity.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../index.php');
    exit;
}

$id  = (int) $_GET['id'];
$dao = new UserDAO(conexao::getConexao());
$dao->delete($id);

header('Location: ../index.php');
exit;