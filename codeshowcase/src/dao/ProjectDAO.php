<?php

namespace App\DAO;

use App\Config\Conexao;
use App\Models\ProjectEntity;

class ProjectDAO {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConexao();
    }

    // CREATE
    public function create(ProjectEntity $project): ProjectEntity {
        $sql = "INSERT INTO projeto (uuid, url, nome_projeto, preco_projeto, categoria_id, ativo)
                VALUES (UUID(), ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $project->getUrl(),
            $project->getNomeProjeto(),
            $project->getPrecoProjeto(),
            $project->getCategoriaId(),
            $project->getAtivo() ? 1 : 0
        ]);

        $project->setId($this->conn->lastInsertId());

        // Busca UUID gerado pelo banco
        $uuid = $this->conn->query("SELECT uuid FROM projeto WHERE id = " . $project->getId())->fetchColumn();
        $project->setUuid($uuid);

        return $project;
    }

    // READ por ID
    public function read(int $id): ?ProjectEntity {
        $sql = "SELECT * FROM projeto WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) return null;

        return new ProjectEntity(
            $dados['id'],
            $dados['uuid'],
            $dados['url'],
            $dados['nome_projeto'],
            $dados['preco_projeto'],
            $dados['categoria_id'],
            $dados['ativo']
        );
    }

    // READ por UUID
    public function readByUuid(string $uuid): ?ProjectEntity {
        $sql = "SELECT * FROM projeto WHERE uuid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$uuid]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) return null;

        return new ProjectEntity(
            $dados['id'],
            $dados['uuid'],
            $dados['url'],
            $dados['nome_projeto'],
            $dados['preco_projeto'],
            $dados['categoria_id'],
            $dados['ativo']
        );
    }

    // READ ALL (com nome da categoria via JOIN)
    public function readAll(): array {
        $sql = "SELECT p.*, c.nome_categoria
                FROM projeto p
                LEFT JOIN categoria c ON p.categoria_id = c.id
                ORDER BY p.nome_projeto";

        $stmt = $this->conn->query($sql);
        $projects = [];

        while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $project = new ProjectEntity(
                $dados['id'],
                $dados['uuid'],
                $dados['url'],
                $dados['nome_projeto'],
                $dados['preco_projeto'],
                $dados['categoria_id'],
                $dados['ativo']
            );
            // Anexa nome da categoria como propriedade extra para uso nas views
            $project->nomeCategoria = $dados['nome_categoria'] ?? '—';
            $projects[] = $project;
        }

        return $projects;
    }

    // READ somente ativos
    public function readAtivos(): array {
        $sql = "SELECT p.*, c.nome_categoria
                FROM projeto p
                LEFT JOIN categoria c ON p.categoria_id = c.id
                WHERE p.ativo = 1
                ORDER BY p.nome_projeto";

        $stmt = $this->conn->query($sql);
        $projects = [];

        while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $project = new ProjectEntity(
                $dados['id'],
                $dados['uuid'],
                $dados['url'],
                $dados['nome_projeto'],
                $dados['preco_projeto'],
                $dados['categoria_id'],
                $dados['ativo']
            );
            $project->nomeCategoria = $dados['nome_categoria'] ?? '—';
            $projects[] = $project;
        }

        return $projects;
    }

    // UPDATE
    public function update(ProjectEntity $project): bool {
        $sql = "UPDATE projeto
                SET url = ?, nome_projeto = ?, preco_projeto = ?, categoria_id = ?, ativo = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $project->getUrl(),
            $project->getNomeProjeto(),
            $project->getPrecoProjeto(),
            $project->getCategoriaId(),
            $project->getAtivo() ? 1 : 0,
            $project->getId()
        ]);
    }

    // DELETE
    public function delete(int $id): bool {
        $sql = "DELETE FROM projeto WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Busca todas as categorias para popular o <select>
    public function getCategorias(): array {
        $sql = "SELECT id, nome_categoria FROM categoria ORDER BY nome_categoria";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>