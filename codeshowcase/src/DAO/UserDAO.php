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
    $sql = "INSERT INTO usuario (nome_usuario, nome_completo, email, senha, dt_nascimento, status) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      $user->getNomeUsuario(),
      $user->getNomeCompleto(),
      $user->getEmail(),
      $user->getSenha(),
      $user->getDataNascimento(),
      $user->getStatus() ? 1 : 0
    ]);
    $user->setId($this->conn->lastInsertId());

    return $user;
  }

  // READ — Busca usuário por ID
  public function read($id) {
    $sql = "SELECT * FROM usuario WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$dados) return null;

    return new UserEntity(
      $dados['id'],
      $dados['nome_usuario'],
      $dados['nome_completo'],
      $dados['email'],
      $dados['senha'],
      $dados['dt_nascimento'],
      $dados['cpf'],
      $dados['dt_cadastro'],
      $dados['status']
    );
  }

  public function findByLogin(string $login): ?UserEntity {
    $sql = "SELECT * FROM usuario WHERE nome_usuario = ? OR email = ? LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$login, $login]);
    $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$dados) {
      return null;
    }

    return new UserEntity(
      $dados['id'],
      $dados['nome_usuario'],
      $dados['nome_completo'],
      $dados['email'],
      $dados['senha'],
      $dados['dt_nascimento'],
      $dados['cpf'],
      $dados['dt_cadastro'],
      $dados['status']
    );
  }

  public function readAll() {
    $sql = "SELECT * FROM usuario ORDER BY nome_completo";
    $stmt = $this->conn->query($sql);
    $users = [];

    // CORRIGIDO: \PDO::FETCH_ASSOC com namespace absoluto
    while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $user = new UserEntity(
        $dados['id'],
        $dados['nome_usuario'],
        $dados['nome_completo'],
        $dados['email'],
        $dados['senha'],
        $dados['dt_nascimento'],
        $dados['cpf'],
        $dados['dt_cadastro'],
        $dados['status']
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

  public function desativar(int $id): bool {
    $sql  = "UPDATE projetos SET status = 0 WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
  }

  public function update(UserEntity $user) {
    $sql = "UPDATE usuario SET nome_usuario = ?, nome_completo = ?, email = ?, senha = ?, dt_nascimento = ?, cpf = ?, status = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
      $user->getNomeUsuario(),
      $user->getNomeCompleto(),
      $user->getEmail(),
      $user->getSenha(),
      $user->getDataNascimento(),
      $user->getCpf(),
      $user->getStatus() ? 1 : 0,
      $user->getId()
    ]);
  }
}
?>