<?php

namespace App\Models;

class Especialidade
{
    private ?int $id = null;
    private string $descricao;
    private ?string $sigla;
    private bool $ativo;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    // Construtor vazio
    public function __construct(
        string $descricao = "",
        ?string $sigla = null,
        bool $ativo = true
    ) {
        $this->descricao = mb_strtoupper($descricao, 'UTF-8');
        $this->sigla = $sigla ? mb_strtoupper($sigla, 'UTF-8') : null;
        $this->ativo = $ativo;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getSigla(): ?string
    {
        return $this->sigla;
    }

    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    // Setters
    public function setDescricao(string $descricao): void
    {
        $this->descricao = mb_strtoupper($descricao, 'UTF-8');
    }

    public function setSigla(?string $sigla): void
    {
        $this->sigla = $sigla ? mb_strtoupper($sigla, 'UTF-8') : null;
    }

    public function setAtivo(bool $ativo): void
    {
        $this->ativo = $ativo;
    }
}