<?php

namespace App\Controller;

use App\Config\Security;
use App\DAO\CompraDAO;
use App\DAO\ProjectDAO;
use App\Models\CompraEntity;
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

    public function meusProjetosView() {
        Security::requireRole(['DESENVOLVEDOR']);

        $devId = $_SESSION['user']['dev_id'] ?? null;
        if (empty($devId)) {
            header('Location: /home');
            exit;
        }

        $dao      = new ProjectDAO();
        $projects = $dao->readByDevId((int) $devId);
        require __DIR__ . '/../Views/MeusProjetosView.php';
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
        Security::requireLogin();

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

        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        if ($userId && (int) $project->getDevId() === $userId) {
            $_SESSION['flash_error'] = 'Você não pode comprar seu próprio projeto.';
            header('Location: /projetos');
            exit;
        }

        $categorias = $dao->getCategorias();
        require __DIR__ . '/../Views/PagamentoProjectView.php';
    }

    public function processarPagamento() {
        Security::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /projetos');
            exit;
        }

        $projectId = (int) ($_POST['id'] ?? 0);
        if ($projectId <= 0) {
            $_SESSION['erro_pagamento'] = 'Projeto inválido.';
            header('Location: /projetos');
            exit;
        }

        $projectDAO = new ProjectDAO();
        $project = $projectDAO->read($projectId);
        if (!$project) {
            $_SESSION['erro_pagamento'] = 'Projeto não encontrado.';
            header('Location: /projetos');
            exit;
        }

        $compradorId = (int) ($_SESSION['user']['id'] ?? 0);
        if ($compradorId === 0) {
            $_SESSION['erro_pagamento'] = 'Faça login para continuar.';
            header('Location: /login');
            exit;
        }

        if ((int) $project->getDevId() === $compradorId) {
            $_SESSION['erro_pagamento'] = 'Você não pode comprar seu próprio projeto.';
            header('Location: /projetos');
            exit;
        }

        $compraDAO = new CompraDAO();
        $compraExistente = $compraDAO->findByProjectAndBuyer($projectId, $compradorId);
        if ($compraExistente && $compraExistente->getStatus() === 'PENDENTE') {
            $checkout = $this->createStripeCheckoutSession($project, $compraExistente);
            if ($checkout['url']) {
                header('Location: ' . $checkout['url']);
                exit;
            }
        }

        $compra = new CompraEntity(
            null,
            $projectId,
            $compradorId,
            (int) $project->getDevId(),
            (float) $project->getPrecoProjeto(),
            'PENDENTE',
            'STRIPE',
            null,
            null,
            date('Y-m-d H:i:s'),
            null
        );

        $compra = $compraDAO->create($compra);

        $checkout = $this->createStripeCheckoutSession($project, $compra);
        if (!$checkout['url']) {
            $_SESSION['erro_pagamento'] = 'Não foi possível iniciar o pagamento. Verifique a configuração do Stripe.';
            header('Location: /projetos/pagamento?id=' . urlencode((string) $projectId));
            exit;
        }

        $compraDAO->updateSession((int) $compra->getId(), (string) $checkout['session_id']);
        header('Location: ' . $checkout['url']);
        exit;
    }

    public function sucessoView() {
        Security::initSession();

        $sessionId = $_GET['session_id'] ?? null;
        $compraId = (int) ($_GET['compra_id'] ?? 0);

        if ($sessionId) {
            $compraDAO = new CompraDAO();
            $compra = $compraId > 0 ? $compraDAO->findById($compraId) : $compraDAO->findByStripeSessionId((string) $sessionId);

            if ($compra) {
                $statusPago = $this->verifyStripeSessionPayment((string) $sessionId, (int) $compra->getId());
                if ($statusPago) {
                    $compraDAO->updateStatus((int) $compra->getId(), 'PAGO');
                    $_SESSION['compra_sucesso'] = 'Pagamento confirmado com sucesso!';
                }
            }
        }

        $compraAtual = null;
        if (!empty($_SESSION['compra_sucesso'])) {
            $compraAtual = $compraId ? (new CompraDAO())->findById($compraId) : null;
        }

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
            $_SESSION['flash_error'] = 'Não é possível espaços vazios.';
            header('Location: /projetos/cadastro');
            exit;
        }

        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleUpload($_FILES['image']);
            if (!$imagePath){
                $_SESSION['flash_error'] = 'Não foi possível processar sua imagem.';
                header('Location: /projetos/cadastro');
                exit;
            }    
        }

        $devId = $_SESSION['user']['dev_id'] ?? null;
        if (empty($devId)) {
            $_SESSION['flash_error'] = 'Seu devID não é válido.';
            header('Location: /projetos/cadastro');
            exit;
        }

        if (!is_numeric($precoProjeto) || $precoProjeto < 0 || $precoProjeto > 99999999.99) {
            $_SESSION['flash_error'] = 'Seu preço é inválido ou não permitido.';
            header('Location: /projetos/cadastro');
            exit;
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

    private function createStripeCheckoutSession(ProjectEntity $project, CompraEntity $compra): array {
        $secretKey = getenv('STRIPE_SECRET_KEY') ?: ($_ENV['STRIPE_SECRET_KEY'] ?? '');
        if (empty($secretKey)) {
            return ['url' => '', 'session_id' => ''];
        }

        $baseUrl = (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost');
        $payload = [
            'line_items' => [[
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => [
                        'name' => $project->getNomeProjeto(),
                    ],
                    'unit_amount' => (int) round((float) $project->getPrecoProjeto() * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $baseUrl . '/comprar/sucesso?session_id={CHECKOUT_SESSION_ID}&compra_id=' . urlencode((string) $compra->getId()),
            'cancel_url' => $baseUrl . '/projetos/pagamento?id=' . urlencode((string) $project->getId()),
            'customer_email' => $_SESSION['user']['email'] ?? '',
            'metadata' => [
                'compra_id' => (string) $compra->getId(),
                'projeto_id' => (string) $project->getId(),
            ],
        ];

        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $secretKey,
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false || $httpCode >= 400) {
            $message = curl_error($ch);
            error_log('Stripe checkout error: ' . ($message ?: 'HTTP ' . $httpCode));
            curl_close($ch);
            return ['url' => '', 'session_id' => ''];
        }

        curl_close($ch);
        $body = json_decode($response, true);

        return [
            'url' => $body['url'] ?? '',
            'session_id' => $body['id'] ?? '',
        ];
    }

    private function verifyStripeSessionPayment(string $sessionId, int $compraId): bool {
        $secretKey = getenv('STRIPE_SECRET_KEY') ?: ($_ENV['STRIPE_SECRET_KEY'] ?? '');
        if (empty($secretKey) || empty($sessionId)) {
            return false;
        }

        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions/' . rawurlencode($sessionId));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $secretKey,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpCode >= 400) {
            return false;
        }

        $body = json_decode($response, true);
        if (($body['payment_status'] ?? '') !== 'paid' && ($body['status'] ?? '') !== 'complete') {
            return false;
        }

        $compraDAO = new CompraDAO();
        $compraDAO->updateStatus($compraId, 'PAGO');
        $compraDAO->updatePaymentIntent($compraId, $body['payment_intent'] ?? '');

        return true;
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
