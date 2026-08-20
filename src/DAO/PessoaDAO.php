<?php

namespace App\DAO;

use App\Models\Pessoa;
use App\Database;
use App\Utils\Formatter;
use PDO;

class PessoaDAO
{

    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // INSERT
    public function insert(Pessoa $pessoa): bool
    {
        $sql = "INSERT INTO pessoas (nome, telefone, cpf, endereco) 
                VALUES (:nome, :telefone, :cpf, :endereco)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nome' => $pessoa->getNome(),
            ':telefone' => $pessoa->getTelefone(),
            ':cpf' => $pessoa->getCpf(),
            ':endereco' => $pessoa->getEndereco()
        ]);

    }

    // LISTAR TODOS
    public function findAll(): array
    {
        $sql = "SELECT id, nome, telefone, cpf, endereco, createdAt, updatedAt FROM pessoas";
        $stmt = $this->conn->query($sql);
        $pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Aplica os formatadores
        foreach ($pessoas as &$pessoa) {
            $pessoa['cpf'] = Formatter::formatCpf($pessoa['cpf']);
            $pessoa['telefone'] = Formatter::formatTelefone($pessoa['telefone']);
            
        }

        return $pessoas;
    }
    

    public function findByNome(string $nome): array
{
    $sql = "SELECT id, nome, telefone, cpf, endereco, createdAt, updatedAt 
            FROM pessoas 
            WHERE nome LIKE :nome";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':nome' => "%$nome%"]);

    $pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Aplica os formatadores
    foreach ($pessoas as &$pessoa) {
        $pessoa['cpf'] = Formatter::formatCpf($pessoa['cpf']);
        $pessoa['telefone'] = Formatter::formatTelefone($pessoa['telefone']);
    }

    return $pessoas;
}
  
    // BUSCAR POR ID
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM pessoas WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }


    public function update(Pessoa $pessoa): bool
    {
        $sql = "UPDATE pessoas 
            SET nome = :nome, telefone = :telefone, cpf = :cpf, endereco = :endereco 
            WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nome' => $pessoa->getNome(),
            ':telefone' => $pessoa->getTelefone(),
            ':cpf' => $pessoa->getCpf(),
            ':endereco' => $pessoa->getEndereco(),
            ':id' => $pessoa->getId()
        ]);

        // Aqui você pode depurar:
        $linhas = $stmt->rowCount();
        if ($linhas > 0) {
            return true; // Atualizou pelo menos uma linha
        } else {
            return false; // Nenhuma linha foi alterada
        }
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM pessoas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }


}
