<?php

namespace App\DAO;

use PDO;
use App\Database;

class MovimentacaoDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    // INSERIR movimentação
    public function insert(array $dados): bool
    {
        $sql = "INSERT INTO movimentacao (idPessoa, Credito, Debito, Observacao, DataOperacao, CreatedAt)
                VALUES (:idPessoa, :Credito, :Debito, :Observacao, NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idPessoa' => $dados['idPessoa'],
            ':Credito' => $dados['Credito'],
            ':Debito' => $dados['Debito'],
            ':Observacao' => $dados['Observacao']
        ]);
    }

    // LISTAR TODAS movimentações
    public function findAll(): array
    {
        $sql = "SELECT m.id, m.idPessoa, p.nome, m.Credito, m.Debito, m.DataOperacao, m.Observacao
                FROM movimentacao m
                INNER JOIN pessoas p ON p.id = m.idPessoa
                ORDER BY m.DataOperacao DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LISTAR movimentações de uma pessoa
    public function findByPessoa(int $idPessoa): array
    {
        $sql = "SELECT id, Credito, Debito, DataOperacao, Observacao
                FROM movimentacao
                WHERE idPessoa = :idPessoa
                ORDER BY DataOperacao DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idPessoa' => $idPessoa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // SALDO resumido
    public function getSaldo(int $idPessoa): float
    {
        $sql = "SELECT COALESCE(SUM(Credito),0) - COALESCE(SUM(Debito),0) AS saldo
                FROM movimentacao
                WHERE idPessoa = :idPessoa";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idPessoa' => $idPessoa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) $row['saldo'];
    }


    public function getSaldosResumidos(): array
    {
        $sql = "SELECT p.id AS idPessoa, p.nome,
                   COALESCE(SUM(m.Credito),0) - COALESCE(SUM(m.Debito),0) AS saldo
            FROM pessoas p
            LEFT JOIN movimentacao m ON m.idPessoa = p.id
            GROUP BY p.id, p.nome
            ORDER BY p.nome";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
