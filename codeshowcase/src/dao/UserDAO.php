<?php

namespace App\dao;

use App\Config\Conexao;
use App\models\UserEntity;

class UserDAO {
  private $conn;

  public function __construct() {
    $this->conn = Conexao::getConexao();
  }

  // CREATE — Insere uma Pessoa no banco
  public function create(UserEntity $user) {
    $sql = "INSERT INTO usuario (nome_completo, email, dt_nascimento, cpf, senha) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$user->getNomeCompleto(), $user->getEmail(), $user->getDataNascimento(), $user->getCpf(), $user->getSenha()]);
    $user->setId($this->conn->lastInsertId());

    return $user;
  }

  // READ — Busca Pessoa por ID
  public function read($id) {
    $sql = "SELECT * FROM pessoas_tb WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dados) return null;
    $user = new Pessoa($dados['nome'], $dados['cpf'], $dados['email'], $dados['idade']);
    $user->setId($dados['id']);

    return $user;
  }

  public function readAll() {
    $sql = "SELECT * FROM pessoas_tb ORDER BY nome";
    $stmt = $this->conn->query($sql);
    $pessoas = [];

    while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $user = new UserEntity(
        $dados['nome'],
        $dados['cpf'],
        $dados['email'],
        $dados['idade'],
        $dados['id']
      );
      $user->setId($dados['id']);
      $pessoas[] = $user; // adiciona ao array
    }
    return $pessoas;
  }

  public function delete($id) {
    $sql = "DELETE FROM pessoas_tb WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
  }

  public function update(UserEntity $user) {
    $sql = "UPDATE pessoas_tb SET nome = ?, cpf = ?, email = ?, idade = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$user->getNome(), $user->getCpf(), $user->getEmail(), $user->getIdade(), $user->getId()]);
  }
}
?>