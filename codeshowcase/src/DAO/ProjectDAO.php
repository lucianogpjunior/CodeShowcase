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
        $sql = "INSERT INTO projetos (url, image, nome, titulo, descricao, preco, status, categoria_id, dev_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $project->getUrl(),
            $project->getImage(),
            $project->getNome(),
            $project->getTitulo(),
            $project->getDescricao(),
            $project->getPreco(),
            $project->getStatus() ? 1 : 0,
            $project->getCategoriaId(),
            $project->getDevId()
        ]);

        $project->setId($this->conn->lastInsertId());
        return $project;
    }

    // READ por ID
    public function read(int $id): ?ProjectEntity {
        $sql  = "SELECT p.*, c.categoria AS categoria_nome
                 FROM projetos p
                 LEFT JOIN categorias c ON p.categoria_id = c.id
                 WHERE p.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) return null;
        return $this->hydrate($dados);
    }

    // READ ALL com nome da categoria
    public function readAll(): array {
        $sql  = "SELECT p.*, c.categoria AS categoria_nome
                 FROM projetos p
                 LEFT JOIN categorias c ON p.categoria_id = c.id
                 ORDER BY p.nome";
        $stmt = $this->conn->query($sql);
        return $this->hydrateAll($stmt);
    }

    // READ somente ativos
    public function readAtivos(): array {
        $sql  = "SELECT p.*, c.categoria AS categoria_nome
                 FROM projetos p
                 LEFT JOIN categorias c ON p.categoria_id = c.id
                 WHERE p.status = 1
                 ORDER BY p.nome";
        $stmt = $this->conn->query($sql);
        return $this->hydrateAll($stmt);
    }

    // UPDATE — atualiza pelo ID interno
    public function update(ProjectEntity $project): bool {
        $sql  = "UPDATE projetos
                 SET url = ?, image = ?, nome = ?, titulo = ?, descricao = ?, preco = ?, status = ?, categoria_id = ?, dev_id = ?
                 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $project->getUrl(),
            $project->getImage(),
            $project->getNome(),
            $project->getTitulo(),
            $project->getDescricao(),
            $project->getPreco(),
            $project->getStatus() ? 1 : 0,
            $project->getCategoriaId(),
            $project->getDevId(),
            $project->getId()
        ]);
    }

    public function desativar(int $id): bool {
        $sql  = "UPDATE projetos SET status = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function delete(int $id): bool {
        $sql  = "DELETE FROM projetos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Busca categorias para o <select>
    public function getCategorias(): array {
        $sql  = "SELECT id, categoria AS categoria_nome FROM categorias ORDER BY categoria";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // ── Helpers ──────────────────────────────────────────────

    private function hydrate(array $dados): ProjectEntity {
        $project = new ProjectEntity(
            $dados['id'],
            $dados['url'] ?? '',
            $dados['image'] ?? '',
            $dados['nome'] ?? '',
            $dados['titulo'] ?? '',
            $dados['descricao'] ?? '',
            $dados['preco'] ?? 0,
            $dados['categoria_id'] ?? 0,
            $dados['status'] ?? 0,
            $dados['dev_id'] ?? 0
        );
        $project->nomeCategoria = $dados['categoria_nome'] ?? '—';
        return $project;
    }

    private function hydrateAll($stmt): array {
        $projects = [];
        while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $projects[] = $this->hydrate($dados);
        }
        return $projects;
    }
}
?>