<?php

namespace App\Models;

class CompraEntity
{
    private ?int $id = null;
    private int $projetoId;
    private int $compradorId;
    private int $vendedorId;
    private float $valor;
    private string $status = 'PENDENTE';
    private string $metodo = 'STRIPE';
    private ?string $stripeSessionId = null;
    private ?string $stripePaymentIntentId = null;
    private ?string $dataCriacao = null;
    private ?string $dataAtualizacao = null;

    public function __construct(
        ?int $id,
        int $projetoId,
        int $compradorId,
        int $vendedorId,
        float $valor,
        string $status = 'PENDENTE',
        string $metodo = 'STRIPE',
        ?string $stripeSessionId = null,
        ?string $stripePaymentIntentId = null,
        ?string $dataCriacao = null,
        ?string $dataAtualizacao = null
    ) {
        $this->id = $id;
        $this->projetoId = $projetoId;
        $this->compradorId = $compradorId;
        $this->vendedorId = $vendedorId;
        $this->valor = $valor;
        $this->status = $status;
        $this->metodo = $metodo;
        $this->stripeSessionId = $stripeSessionId;
        $this->stripePaymentIntentId = $stripePaymentIntentId;
        $this->dataCriacao = $dataCriacao ?? date('Y-m-d H:i:s');
        $this->dataAtualizacao = $dataAtualizacao;
    }

    public function getId(): ?int { return $this->id; }
    public function getProjetoId(): int { return $this->projetoId; }
    public function getCompradorId(): int { return $this->compradorId; }
    public function getVendedorId(): int { return $this->vendedorId; }
    public function getValor(): float { return $this->valor; }
    public function getStatus(): string { return $this->status; }
    public function getMetodo(): string { return $this->metodo; }
    public function getStripeSessionId(): ?string { return $this->stripeSessionId; }
    public function getStripePaymentIntentId(): ?string { return $this->stripePaymentIntentId; }
    public function getDataCriacao(): ?string { return $this->dataCriacao; }
    public function getDataAtualizacao(): ?string { return $this->dataAtualizacao; }

    public function setId(?int $id): void { $this->id = $id; }
    public function setProjetoId(int $projetoId): void { $this->projetoId = $projetoId; }
    public function setCompradorId(int $compradorId): void { $this->compradorId = $compradorId; }
    public function setVendedorId(int $vendedorId): void { $this->vendedorId = $vendedorId; }
    public function setValor(float $valor): void { $this->valor = $valor; }
    public function setStatus(string $status): void { $this->status = $status; }
    public function setMetodo(string $metodo): void { $this->metodo = $metodo; }
    public function setStripeSessionId(?string $stripeSessionId): void { $this->stripeSessionId = $stripeSessionId; }
    public function setStripePaymentIntentId(?string $stripePaymentIntentId): void { $this->stripePaymentIntentId = $stripePaymentIntentId; }
    public function setDataCriacao(?string $dataCriacao): void { $this->dataCriacao = $dataCriacao; }
    public function setDataAtualizacao(?string $dataAtualizacao): void { $this->dataAtualizacao = $dataAtualizacao; }
}
