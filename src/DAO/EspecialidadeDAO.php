<?php

namespace App\DAO;

use App\Models\Especialidade;
use App\Database;
use PDO;

class EspecialidadeDAO
{

    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // INSERT
    public function insert(Especialidade $especialidade): bool
    {
        $sql = "INSERT INTO especialidades (descricao, sigla, ativo) 
                VALUES (:descricao, :sigla, :ativo)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':descricao' => $especialidade->getDescricao(),
            ':sigla' => $especialidade->getSigla(),
            ':ativo' => (int) $especialidade->isAtivo()
        ]);

    }

    // LISTAR TODOS
    public function findAll(): array
    {
        $sql = "SELECT id, descricao, sigla, ativo, createdAt, updatedAt FROM especialidades";
        $sql = "SELECT * FROM especialidades";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findByDescricao(string $descricao): array
    {
        $sql = "SELECT * FROM especialidades 
                WHERE descricao LIKE :descricao";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':descricao' => "%$descricao%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // BUSCAR POR ID
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM especialidades WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }


    public function update(Especialidade $especialidade): bool
    {
        $sql = "UPDATE especialidades 
            SET descricao = :descricao, sigla = :sigla, ativo = :ativo 
            WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':descricao' => $especialidade->getDescricao(),
            ':sigla' => $especialidade->getSigla(),
            ':ativo' => (int) $especialidade->isAtivo(),
            ':id' => $especialidade->getId()
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
        $sql = "DELETE FROM especialidades WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }


}