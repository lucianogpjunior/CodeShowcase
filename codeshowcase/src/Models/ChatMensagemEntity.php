<?php

namespace App\Models;

class ChatMensagemEntity
{
    private ?int $id = null;
    private int $compraId;
    private int $remetenteId;
    private int $destinatarioId;
    private string $mensagem;
    private string $tipo = 'TEXT';
    private ?string $criadoEm = null;

    public function __construct(
        ?int $id,
        int $compraId,
        int $remetenteId,
        int $destinatarioId,
        string $mensagem,
        string $tipo = 'TEXT',
        ?string $criadoEm = null
    ) {
        $this->id = $id;
        $this->compraId = $compraId;
        $this->remetenteId = $remetenteId;
        $this->destinatarioId = $destinatarioId;
        $this->mensagem = $mensagem;
        $this->tipo = $tipo;
        $this->criadoEm = $criadoEm ?? date('Y-m-d H:i:s');
    }

    public function getId(): ?int { return $this->id; }
    public function getCompraId(): int { return $this->compraId; }
    public function getRemetenteId(): int { return $this->remetenteId; }
    public function getDestinatarioId(): int { return $this->destinatarioId; }
    public function getMensagem(): string { return $this->mensagem; }
    public function getTipo(): string { return $this->tipo; }
    public function getCriadoEm(): ?string { return $this->criadoEm; }

    public function setId(?int $id): void { $this->id = $id; }
    public function setCompraId(int $compraId): void { $this->compraId = $compraId; }
    public function setRemetenteId(int $remetenteId): void { $this->remetenteId = $remetenteId; }
    public function setDestinatarioId(int $destinatarioId): void { $this->destinatarioId = $destinatarioId; }
    public function setMensagem(string $mensagem): void { $this->mensagem = trim($mensagem); }
    public function setTipo(string $tipo): void { $this->tipo = $tipo; }
    public function setCriadoEm(?string $criadoEm): void { $this->criadoEm = $criadoEm; }
}
