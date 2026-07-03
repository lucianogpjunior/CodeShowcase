<?php

namespace App\Controller;

use App\DAO\ProjectDAO;
use App\Models\ProjectEntity;

class ProjectController {

    // ── Views ────────────────────────────────────────────────

    public function index() {
        $dao      = new ProjectDAO();
        $projects = $dao->readAtivos();
        require __DIR__ . '/../views/ProjectView.php';
    }

    public function cadastroView() {
        $dao        = new ProjectDAO();
        $categorias = $dao->getCategorias();
        require __DIR__ . '/../views/CadastroProjectView.php';
    }

    // UUID na URL — impossível de adivinhar
    public function editView() {
        if (empty($_GET['uuid'])) {
            header('Location: /projetos');
            exit;
        }

        $dao     = new ProjectDAO();
        $project = $dao->readByUuid($_GET['uuid']);

        if (!$project) {
            header('Location: /projetos');
            exit;
        }

        $categorias = $dao->getCategorias();
        require __DIR__ . '/../views/EditProjectView.php';
    }

    // ── CRUD ─────────────────────────────────────────────────

    public function createProject() {
        $nomeProjeto  = trim($_POST['nome_projeto'] ?? '');
        $precoProjeto = $_POST['preco_projeto'] ?? '';
        $categoriaId  = $_POST['categoria_id'] ?? '';
        $ativo        = isset($_POST['ativo']) ? 1 : 0;

        if (empty($nomeProjeto) || $precoProjeto === '' || empty($categoriaId)) {
            die("Todos os campos obrigatórios devem ser preenchidos.");
        }

        $url = '';
        if (isset($_FILES['url']) && $_FILES['url']['error'] === UPLOAD_ERR_OK) {
            $url = $this->handleUpload($_FILES['url']);
            if (!$url) die("Erro no upload da imagem.");
        }

        $project = new ProjectEntity(
            null, null, $url,
            $nomeProjeto,
            (float) $precoProjeto,
            (int) $categoriaId,
            $ativo
        );

        $dao = new ProjectDAO();
        $dao->create($project);

        header('Location: /projetos');
        exit;
    }

    // UUID via hidden input no form — nunca ID numérico
    public function updateProject() {
        if (empty($_POST['uuid'])) {
            header('Location: /projetos');
            exit;
        }

        $dao     = new ProjectDAO();
        $project = $dao->readByUuid($_POST['uuid']);

        if (!$project) {
            header('Location: /projetos');
            exit;
        }

        $project->setNomeProjeto(trim($_POST['nome_projeto'] ?? ''));
        $project->setPrecoProjeto((float) ($_POST['preco_projeto'] ?? 0));
        $project->setCategoriaId((int) ($_POST['categoria_id'] ?? 0));
        $project->setAtivo(isset($_POST['ativo']) ? 1 : 0);

        if (isset($_FILES['url']) && $_FILES['url']['error'] === UPLOAD_ERR_OK) {
            $url = $this->handleUpload($_FILES['url']);
            if ($url) $project->setUrl($url);
        }

        $dao->update($project);

        header('Location: /projetos');
        exit;
    }

    // UUID na URL — desativa sem expor ID
    public function desativarProject() {
        if (empty($_GET['uuid'])) {
            header('Location: /projetos');
            exit;
        }

        $dao = new ProjectDAO();
        $dao->desativar($_GET['uuid']);

        header('Location: /projetos');
        exit;
    }

    // ── Helper de upload ─────────────────────────────────────

    private function handleUpload(array $file): string|false {
        $uploadDir    = __DIR__ . '/../../public/assets/uploads/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

        if (!in_array($file['type'], $allowedTypes)) return false;
        if ($file['size'] > 5 * 1024 * 1024) return false;

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('proj_', true) . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) return false;

        return '/assets/uploads/' . $filename;
    }
}
?>