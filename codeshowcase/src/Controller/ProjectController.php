<?php

namespace App\Controller;

use App\Config\Security;
use App\DAO\ProjectDAO;
use App\Models\ProjectEntity;

class ProjectController {

    // ── Views ────────────────────────────────────────────────

    public function index() {
        $dao      = new ProjectDAO();
        $projects = $dao->readAtivos();
        require __DIR__ . '/../Views/ProjectView.php';
    }

    public function cadastroView() {
        Security::requireRole(['DESENVOLVEDOR']);

        $dao        = new ProjectDAO();
        $categorias = $dao->getCategorias();
        require __DIR__ . '/../Views/CadastroProjectView.php';
    }

    public function editView() {
        Security::requireRole(['DESENVOLVEDOR']);

        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: /projetos');
            exit;
        }

        $dao     = new ProjectDAO();
        $project = $dao->read((int) $_GET['id']);

        if (!$project) {
            header('Location: /projetos');
            exit;
        }

        $this->assertProjectOwnership($project);

        $categorias = $dao->getCategorias();
        require __DIR__ . '/../Views/EditProjectView.php';
    }

    public function comprarView() {
        if (!isset($_GET['id'])) {
            header('Location: /projetos');
            exit;
        }

        $dao = new ProjectDAO();
        $project = $dao->read((int) $_GET['id']);


        if (!$project) {
            header('Location: /projetos');
            exit;
        }

        require __DIR__ . '/../Views/ComprarProjectView.php';
    }
    
public function pagamentoView() {
    if (!isset($_GET['id'])) {
        header('Location: /projetos');
        exit;
    }

    $dao = new ProjectDAO();
    $project = $dao->read($_GET['id']);

    if (!$project) {
        header('Location: /projetos');
        exit;
    }

    // 🔥 Busca TODAS as categorias (você já tem esse método)
    $categorias = $dao->getCategorias();

    // Passa as duas variáveis para a view
    require __DIR__ . '/../views/PagamentoProjectView.php';
}
public function processarPagamento() {
    // Iniciar sessão
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verifica se é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /projetos');
        exit;
    }

    // Pega os dados
    $uuid = $_POST['id'] ?? '';
    $metodo = $_POST['metodo'] ?? 'cartao';

    // Validação do cartão (só se for cartão)
    if ($metodo === 'cartao') {
        $cartao  = trim($_POST['cartao'] ?? '');
        $validade = trim($_POST['validade'] ?? '');
        $cvv     = trim($_POST['cvv'] ?? '');

        if (empty($cartao) || empty($validade) || empty($cvv)) {
            $_SESSION['erro_pagamento'] = 'Preencha todos os dados do cartão.';
            header('Location: /projetos/pagamento?id=' . urlencode($id));
            exit;
        }
    }

    header('Location: /comprar/sucesso');
    exit;
}

    public function sucessoView() {
        require __DIR__ . '/../Views/SucessoView.php';
    }

    // ── CRUD ─────────────────────────────────────────────────

    public function createProject() {
        Security::requireRole(['DESENVOLVEDOR']);

        $nomeProjeto  = trim($_POST['nome'] ?? '');
        $titulo       = trim($_POST['titulo'] ?? '');
        $descricao    = trim($_POST['descricao'] ?? '');
        $url          = trim($_POST['url'] ?? '');
        $precoProjeto = $_POST['preco'] ?? '';
        $categoriaId  = $_POST['categoria_id'] ?? '';
        $ativo        = isset($_POST['ativo']) ? 1 : 0;

        if (empty($nomeProjeto) || empty($titulo) || empty($descricao) || $precoProjeto === '' || empty($categoriaId)) {
            die("Todos os campos obrigatórios devem ser preenchidos.");
        }

        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleUpload($_FILES['image']);
            if (!$imagePath) die("Erro no upload da imagem.");
        }

        $devId = $_SESSION['user']['dev_id'] ?? null;
        if (empty($devId)) {
            die('Seu cadastro de desenvolvedor não foi encontrado.');
        }

        $project = new ProjectEntity(
            null,
            $url,
            $imagePath,
            $nomeProjeto,
            $titulo,
            $descricao,
            (float) $precoProjeto,
            (int) $categoriaId,
            $ativo,
            (int) $devId
        );

        $dao = new ProjectDAO();
        $dao->create($project);

        header('Location: /projetos');
        exit;
    }

    // Atualiza o projeto usando o ID numérico enviado pelo formulário
    public function updateProject() {
        Security::requireRole(['DESENVOLVEDOR']);

        if (empty($_POST['id']) || !is_numeric($_POST['id'])) {
            header('Location: /projetos');
            exit;
        }

        $dao     = new ProjectDAO();
        $project = $dao->read((int) $_POST['id']);

        if (!$project) {
            header('Location: /projetos');
            exit;
        }

        $this->assertProjectOwnership($project);

        $project->setNomeProjeto(trim($_POST['nome'] ?? ''));
        $project->setTitulo(trim($_POST['titulo'] ?? ''));
        $project->setDescricao(trim($_POST['descricao'] ?? ''));
        $project->setUrl(trim($_POST['url'] ?? ''));
        $project->setPreco((float) ($_POST['preco'] ?? 0));
        $project->setCategoriaId((int) ($_POST['categoria_id'] ?? 0));
        $project->setAtivo(isset($_POST['ativo']) ? 1 : 0);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $this->handleUpload($_FILES['image']);
            if ($image) $project->setImage($image);
        }

        $dao->update($project);

        header('Location: /projetos');
        exit;
    }

    public function desativarProject() {
        Security::requireRole(['DESENVOLVEDOR']);

        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: /projetos');
            exit;
        }

        $dao = new ProjectDAO();
        $project = $dao->read((int) $_GET['id']);

        if (!$project) {
            header('Location: /projetos');
            exit;
        }

        $this->assertProjectOwnership($project);
        $dao->desativar((int) $_GET['id']);

        header('Location: /projetos');
        exit;
    }

    public function deleteProject() {
        Security::requireRole(['DESENVOLVEDOR']);

        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: /projetos');
            exit;
        }

        $dao = new ProjectDAO();
        $project = $dao->read((int) $_GET['id']);

        if (!$project) {
            header('Location: /projetos');
            exit;
        }

        $this->assertProjectOwnership($project);
        $dao->delete((int) $_GET['id']);

        header('Location: /projetos');
        exit;
    }

    private function assertProjectOwnership(ProjectEntity $project): void {
        Security::requireRole(['DESENVOLVEDOR']);

        $devId = $_SESSION['user']['dev_id'] ?? null;
        if ((int) $devId !== (int) $project->getDevId()) {
            header('Location: /projetos');
            exit;
        }
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