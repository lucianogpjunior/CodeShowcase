<?php

require_once(__DIR__ . "/../config/Conexao.php");

class PessoaDAO {
  private $conn;

  public function __construct() {
    $this->conn = Conexao::getConexao();
  }

  // CREATE — Insere uma Pessoa no banco
  public function create(Pessoa $p) {
    $sql = "INSERT INTO usuario (nome_completo, email, dt_nascimento, cpf, senha) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$p->getNome(), $p->getEmail(), $p->getDataNascimento(), $p->getCpf(), $p->getSenha()]);
    $p->setId($this->conn->lastInsertId());

    return $p;
  }

  // READ — Busca Pessoa por ID
  public function read($id) {
    $sql = "SELECT * FROM pessoas_tb WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dados) return null;
    $p = new Pessoa($dados['nome'], $dados['cpf'], $dados['email'], $dados['idade']);
    $p->setId($dados['id']);

    return $p;
  }

  public function readAll() {
    $sql = "SELECT * FROM pessoas_tb ORDER BY nome";
    $stmt = $this->conn->query($sql);
    $pessoas = [];

    while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $p = new Pessoa(
        $dados['nome'],
        $dados['cpf'],
        $dados['email'],
        $dados['idade'],
        $dados['id']
      );
      $p->setId($dados['id']);
      $pessoas[] = $p; // adiciona ao array
    }
    return $pessoas;
  }

  public function delete($id) {
    $sql = "DELETE FROM pessoas_tb WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
  }

  public function update(Pessoa $p) {
    $sql = "UPDATE pessoas_tb SET nome = ?, cpf = ?, email = ?, idade = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$p->getNome(), $p->getCpf(), $p->getEmail(), $p->getIdade(), $p->getId()]);
  }
}
?>