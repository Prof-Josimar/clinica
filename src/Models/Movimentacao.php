<?php

namespace App\Models;

class Movimentacao
{
    private ?int $id = null;
    private int $idPessoa;
    private float $credito = 0.00;
    private float $debito = 0.00;
    private ?string $dataOperacao = null;
    private ?string $observacao = null;
    private ?string $createdAt = null;

    public function __construct(
        int $idPessoa,
        float $credito = 0.00,
        float $debito = 0.00,
        ?string $observacao = null
    ) {
        $this->idPessoa   = $idPessoa;
        $this->credito    = $credito;
        $this->debito     = $debito;
        $this->observacao = $observacao;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPessoa(): int
    {
        return $this->idPessoa;
    }

    public function getCredito(): float
    {
        return $this->credito;
    }

    public function getDebito(): float
    {
        return $this->debito;
    }

    public function getDataOperacao(): ?string
    {
        return $this->dataOperacao;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setIdPessoa(int $idPessoa): void
    {
        $this->idPessoa = $idPessoa;
    }

    public function setCredito(float $credito): void
    {
        $this->credito = $credito;
    }

    public function setDebito(float $debito): void
    {
        $this->debito = $debito;
    }

    public function setDataOperacao(?string $dataOperacao): void
    {
        $this->dataOperacao = $dataOperacao;
    }

    public function setObservacao(?string $observacao): void
    {
        $this->observacao = $observacao;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
