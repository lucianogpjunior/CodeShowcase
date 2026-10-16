<?php

namespace App\DAO;

use App\Config\Conexao;
use App\Models\ChatMensagemEntity;

class ChatMensagemDAO
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::getConexao();
    }

    public function create(ChatMensagemEntity $mensagem): ChatMensagemEntity
    {
        $sql = 'INSERT INTO chat_mensagens (compra_id, remetente_id, destinatario_id, mensagem, tipo, criado_em)
                VALUES (?, ?, ?, ?, ?, NOW())';

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $mensagem->getCompraId(),
            $mensagem->getRemetenteId(),
            $mensagem->getDestinatarioId(),
            $mensagem->getMensagem(),
            $mensagem->getTipo(),
        ]);

        $mensagem->setId((int) $this->conn->lastInsertId());
        return $mensagem;
    }

    public function readByCompraId(int $compraId): array
    {
        $sql  = 'SELECT * FROM chat_mensagens WHERE compra_id = ? ORDER BY id ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$compraId]);

        $lista = [];
        while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $lista[] = $this->hydrate($dados);
        }

        return $lista;
    }

    private function hydrate(array $dados): ChatMensagemEntity
    {
        return new ChatMensagemEntity(
            (int) ($dados['id'] ?? 0),
            (int) ($dados['compra_id'] ?? 0),
            (int) ($dados['remetente_id'] ?? 0),
            (int) ($dados['destinatario_id'] ?? 0),
            (string) ($dados['mensagem'] ?? ''),
            (string) ($dados['tipo'] ?? 'TEXT'),
            $dados['criado_em'] ?? null
        );
    }
}
