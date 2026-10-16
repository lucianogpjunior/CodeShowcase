<?php

namespace App\DAO;

use App\Config\Conexao;
use App\Models\CompraEntity;

class CompraDAO
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::getConexao();
    }

    public function create(CompraEntity $compra): CompraEntity
    {
        $sql = 'INSERT INTO compras (projeto_id, comprador_id, vendedor_id, valor, status, metodo, stripe_session_id, stripe_payment_intent_id, data_criacao, data_atualizacao)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())';

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $compra->getProjetoId(),
            $compra->getCompradorId(),
            $compra->getVendedorId(),
            $compra->getValor(),
            $compra->getStatus(),
            $compra->getMetodo(),
            $compra->getStripeSessionId(),
            $compra->getStripePaymentIntentId(),
        ]);

        $compra->setId((int) $this->conn->lastInsertId());
        return $compra;
    }

    public function findById(int $id): ?CompraEntity
    {
        $sql  = 'SELECT * FROM compras WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $dados ? $this->hydrate($dados) : null;
    }

    public function findByStripeSessionId(string $stripeSessionId): ?CompraEntity
    {
        $sql  = 'SELECT * FROM compras WHERE stripe_session_id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$stripeSessionId]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $dados ? $this->hydrate($dados) : null;
    }

    public function findByProjectAndBuyer(int $projetoId, int $compradorId): ?CompraEntity
    {
        $sql  = 'SELECT * FROM compras WHERE projeto_id = ? AND comprador_id = ? ORDER BY id DESC LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$projetoId, $compradorId]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $dados ? $this->hydrate($dados) : null;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $sql  = 'UPDATE compras SET status = ?, data_atualizacao = NOW() WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    public function updateSession(int $id, string $sessionId): bool
    {
        $sql  = 'UPDATE compras SET stripe_session_id = ?, data_atualizacao = NOW() WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$sessionId, $id]);
    }

    public function updatePaymentIntent(int $id, string $paymentIntentId): bool
    {
        $sql  = 'UPDATE compras SET stripe_payment_intent_id = ?, data_atualizacao = NOW() WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$paymentIntentId, $id]);
    }

    private function hydrate(array $dados): CompraEntity
    {
        return new CompraEntity(
            (int) ($dados['id'] ?? 0),
            (int) ($dados['projeto_id'] ?? 0),
            (int) ($dados['comprador_id'] ?? 0),
            (int) ($dados['vendedor_id'] ?? 0),
            (float) ($dados['valor'] ?? 0),
            (string) ($dados['status'] ?? 'PENDENTE'),
            (string) ($dados['metodo'] ?? 'STRIPE'),
            $dados['stripe_session_id'] ?? null,
            $dados['stripe_payment_intent_id'] ?? null,
            $dados['data_criacao'] ?? null,
            $dados['data_atualizacao'] ?? null
        );
    }
}
