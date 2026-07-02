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
        $sql = "INSERT INTO projetos (uuid_projetos, url_projeto, nome_projeto, preco_projeto, categoria_id, ativo)
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
        $stmt2 = $this->conn->prepare("SELECT uuid_projetos FROM projetos WHERE id = ?");
        $stmt2->execute([$project->getId()]);
        $project->setUuid($stmt2->fetchColumn());

        return $project;
    }

    // READ por ID
    public function read(int $id): ?ProjectEntity {
        $sql  = "SELECT * FROM projetos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) return null;

        return $this->hydrate($dados);
    }

    // READ por UUID
    public function readByUuid(string $uuid): ?ProjectEntity {
        $sql  = "SELECT * FROM projetos WHERE uuid_projetos = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$uuid]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) return null;

        return $this->hydrate($dados);
    }

    // READ ALL com nome da categoria
    public function readAll(): array {
        $sql = "SELECT p.*, c.categoria_nome
                FROM projetos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.nome_projeto";

        $stmt = $this->conn->query($sql);
        return $this->hydrateAll($stmt);
    }

    // READ somente ativos
    public function readAtivos(): array {
        $sql = "SELECT p.*, c.categoria_nome
                FROM projetos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                WHERE p.ativo = 1
                ORDER BY p.nome_projeto";

        $stmt = $this->conn->query($sql);
        return $this->hydrateAll($stmt);
    }

    // UPDATE
    public function update(ProjectEntity $project): bool {
        $sql  = "UPDATE projetos
                 SET url_projeto = ?, nome_projeto = ?, preco_projeto = ?, categoria_id = ?, ativo = ?
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
        $sql  = "DELETE FROM projetos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Busca categorias para o <select>
    public function getCategorias(): array {
        $sql  = "SELECT id, categoria_nome FROM categorias ORDER BY categoria_nome";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // ── Helpers ──────────────────────────────────────────────

    // Monta um ProjectEntity a partir de uma linha do banco
    private function hydrate(array $dados): ProjectEntity {
        $project = new ProjectEntity(
            $dados['id'],
            $dados['uuid_projetos'],
            $dados['url_projeto'],
            $dados['nome_projeto'],
            $dados['preco_projeto'],
            $dados['categoria_id'],
            $dados['ativo']
        );
        $project->nomeCategoria = $dados['categoria_nome'] ?? '—';
        return $project;
    }

    // Itera statement e retorna array de ProjectEntity
    private function hydrateAll($stmt): array {
        $projects = [];
        while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $projects[] = $this->hydrate($dados);
        }
        return $projects;
    }
}
?>