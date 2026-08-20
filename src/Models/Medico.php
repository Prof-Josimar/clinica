<?php

namespace App\Models;

class Medico
{
    private ?int $id = null;
    private string $nome;
    private ?string $telefone;
    private string $cpf;
    private ?string $endereco;
    private string $crm;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    /** @var Especialidade[] */
    private array $especialidades = [];

    // Construtor
    public function __construct(
        string $nome = "",
        ?string $telefone = null,
        string $cpf = "",
        ?string $endereco = null,
        string $crm = ""
    ) {
        $this->nome = mb_strtoupper($nome, 'UTF-8');
        $this->telefone = $telefone;
        $this->cpf = $cpf;
        $this->endereco = $endereco ? mb_strtoupper($endereco, 'UTF-8') : null;
        $this->crm = strtoupper($crm);
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
        $cpf = preg_replace('/\D/', '', $this->cpf);
        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' .
                substr($cpf, 3, 3) . '.' .
                substr($cpf, 6, 3) . '-' .
                substr($cpf, 9, 2);
        }
        return $this->cpf;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function getCrm(): string
    {
        return $this->crm;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /** @return Especialidade[] */
    public function getEspecialidades(): array
    {
        return $this->especialidades;
    }

    public function getEspecialidadeIds(): array
    {
        return array_map(fn(Especialidade $e) => $e->getId(), $this->especialidades);
    }

    public function getEspecialidadesDescricao(): string
    {
        return implode(', ', array_map(fn(Especialidade $e) => $e->getDescricao(), $this->especialidades));
    }

    // Setters
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
        $this->endereco = $endereco ? mb_strtoupper($endereco, 'UTF-8') : null;
    }

    public function setCrm(string $crm): void
    {
        $this->crm = strtoupper($crm);
    }

    /** @param Especialidade[] $especialidades */
    public function setEspecialidades(array $especialidades): void
    {
        $this->especialidades = $especialidades;
    }

    public function addEspecialidade(Especialidade $especialidade): void
    {
        foreach ($this->especialidades as $e) {
            if ($e->getId() === $especialidade->getId()) {
                return;
            }
        }
        $this->especialidades[] = $especialidade;
    }

    public function removeEspecialidade(int $especialidadeId): void
    {
        $this->especialidades = array_values(array_filter(
            $this->especialidades,
            fn(Especialidade $e) => $e->getId() !== $especialidadeId
        ));
    }
}