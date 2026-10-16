<?php

namespace App\Controller;

use App\Config\Security;
use App\DAO\ChatMensagemDAO;
use App\DAO\CompraDAO;
use App\DAO\ProjectDAO;
use App\Models\ChatMensagemEntity;

class ChatController
{
    public function index(): void
    {
        Security::requireLogin();

        $compraId = (int) ($_GET['compra_id'] ?? 0);
        if ($compraId <= 0) {
            header('Location: /projetos');
            exit;
        }

        $compraDAO = new CompraDAO();
        $compra = $compraDAO->findById($compraId);
        if (!$compra) {
            header('Location: /projetos');
            exit;
        }

        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        if ($compra->getCompradorId() !== $userId && $compra->getVendedorId() !== $userId) {
            header('Location: /projetos');
            exit;
        }

        $projectDAO = new ProjectDAO();
        $project = $projectDAO->read((int) $compra->getProjetoId());
        $chatDAO = new ChatMensagemDAO();
        $mensagens = $chatDAO->readByCompraId($compraId);

        require __DIR__ . '/../Views/ChatView.php';
    }

    public function enviarMensagem(): void
    {
        Security::requireLogin();

        $compraId = (int) ($_POST['compra_id'] ?? 0);
        $mensagem = trim((string) ($_POST['mensagem'] ?? ''));

        if ($compraId <= 0 || $mensagem === '') {
            header('Location: /projetos');
            exit;
        }

        $compraDAO = new CompraDAO();
        $compra = $compraDAO->findById($compraId);
        if (!$compra) {
            header('Location: /projetos');
            exit;
        }

        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        if ($compra->getCompradorId() !== $userId && $compra->getVendedorId() !== $userId) {
            header('Location: /projetos');
            exit;
        }

        $destinatarioId = $userId === $compra->getCompradorId()
            ? $compra->getVendedorId()
            : $compra->getCompradorId();

        $chatDAO = new ChatMensagemDAO();
        $chatDAO->create(new ChatMensagemEntity(
            null,
            $compra->getId(),
            $userId,
            $destinatarioId,
            $mensagem,
            'TEXT',
            date('Y-m-d H:i:s')
        ));

        header('Location: /chat?compra_id=' . $compraId);
        exit;
    }

    public function mensagens(): void
    {
        Security::requireLogin();

        $compraId = (int) ($_GET['compra_id'] ?? 0);
        if ($compraId <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'compra_id inválido']);
            exit;
        }

        $compraDAO = new CompraDAO();
        $compra = $compraDAO->findById($compraId);
        if (!$compra) {
            http_response_code(404);
            echo json_encode(['error' => 'compra não encontrada']);
            exit;
        }

        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        if ($compra->getCompradorId() !== $userId && $compra->getVendedorId() !== $userId) {
            http_response_code(403);
            echo json_encode(['error' => 'acesso negado']);
            exit;
        }

        $chatDAO = new ChatMensagemDAO();
        $mensagens = $chatDAO->readByCompraId($compraId);

        header('Content-Type: application/json');
        echo json_encode(array_map(function ($msg) use ($userId) {
            return [
                'id' => $msg->getId(),
                'mensagem' => $msg->getMensagem(),
                'tipo' => $msg->getTipo(),
                'remetente_id' => $msg->getRemetenteId(),
                'eh_minha' => $msg->getRemetenteId() === $userId,
                'criado_em' => $msg->getCriadoEm(),
            ];
        }, $mensagens));
        exit;
    }
}
