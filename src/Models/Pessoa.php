<?php

namespace App\Models;
class Pessoa

{
    private ?int $id = null;
    private string $nome;
    private ?string $telefone;
    private string $cpf;
    private ?string $endereco;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    // Construtor vazio
    public function __construct(
        string $nome = "",
        ?string $telefone = null,
        string $cpf = "",
        ?string $endereco = null
    ) {
        $this->nome = strtoupper($nome);
        $this->telefone = $telefone;
        $this->cpf = $cpf;
        $this->endereco = $endereco ? strtoupper($endereco) : null;
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

    public function getNome(): string
    {
        return $this->nome;
    }


    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    // Getter formatado
    public function getCpfFormatado(): string
    {
        $cpf = preg_replace('/\D/', '', $this->cpf); // remove tudo que não é número

        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' .
                substr($cpf, 3, 3) . '.' .
                substr($cpf, 6, 3) . '-' .
                substr($cpf, 9, 2);
        }

        // se não tiver 11 dígitos, retorna como está
        return $this->cpf;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }


    public function setNome(string $nome): void
    {
        $this->nome = mb_strtoupper($nome, 'UTF-8');
    }
    
    public function setTelefone(?string $telefone): void
    {
        $this->telefone = $telefone;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function setEndereco(?string $endereco): void
    {
        $this->endereco = $endereco ? strtoupper($endereco) : null;
    }
}
