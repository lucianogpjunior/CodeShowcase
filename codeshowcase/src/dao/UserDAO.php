<?php

namespace App\DAO;

use App\Config\Conexao;
use App\Models\UserEntity;

class UserDAO {
  private $conn;

  public function __construct() {
    $this->conn = Conexao::getConexao();
  }

  // CREATE — Insere um usuário no banco
  public function create(UserEntity $user) {
    $sql = "INSERT INTO usuario (nome_completo, email, dt_nascimento, cpf, senha) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      $user->getNomeCompleto(),
      $user->getEmail(),
      $user->getDataNascimento(),
      $user->getCpf(),
      $user->getSenha()
    ]);
    $user->setId($this->conn->lastInsertId());

    return $user;
  }

  // READ — Busca usuário por ID
  public function read($id) {
    $sql = "SELECT * FROM usuario WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    // CORRIGIDO: \PDO::FETCH_ASSOC com namespace absoluto
    $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$dados) return null;

    // CORRIGIDO: estava faltando "UserEntity" na instanciação (era "new ($dados...)")
    $user = new UserEntity(
      $dados['id'],
      $dados['nome_completo'],
      $dados['email'],
      $dados['dt_nascimento'],
      $dados['cpf'],
      $dados['senha'],
      $dados['data_cadastro']
    );

    return $user;
  }

  public function readAll() {
    $sql = "SELECT * FROM usuario ORDER BY nome_completo";
    $stmt = $this->conn->query($sql);
    $users = [];

    // CORRIGIDO: \PDO::FETCH_ASSOC com namespace absoluto
    while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $user = new UserEntity(
        $dados['id'],
        $dados['nome_completo'],
        $dados['email'],
        $dados['dt_nascimento'],
        $dados['cpf'],
        $dados['senha'],
        $dados['data_cadastro']
      );
      // REMOVIDO: setId() duplicado — id já é passado no construtor
      $users[] = $user;
    }
    return $users;
  }

  public function delete($id) {
    $sql = "DELETE FROM usuario WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
  }

  public function update(UserEntity $user) {
    $sql = "UPDATE usuario SET nome_completo = ?, email = ?, dt_nascimento = ?, cpf = ?, senha = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
      $user->getNomeCompleto(),
      $user->getEmail(),
      $user->getDataNascimento(),
      $user->getCpf(),
      $user->getSenha(),
      $user->getId()
    ]);
  }
}
?>