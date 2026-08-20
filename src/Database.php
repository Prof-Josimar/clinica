<?php

namespace App;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $db   = "aulapdo";
    private $user = "root";
    private $pass = "";
    private $charset = "utf8mb4";

    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function createTablePessoas() {
        try {
            $pdo = $this->connect();
            $sql = "
                CREATE TABLE IF NOT EXISTS pessoas (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    nome VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
                    telefone VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                    cpf VARCHAR(11) NOT NULL COLLATE 'utf8mb4_general_ci',
                    endereco VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                    createdAt TIMESTAMP NULL DEFAULT current_timestamp(),
                    updatedAt TIMESTAMP NULL DEFAULT NULL,
                    PRIMARY KEY (id) USING BTREE,
                    UNIQUE INDEX cpf (cpf) USING BTREE
                ) COLLATE='utf8mb4_general_ci' ENGINE=InnoDB;
            ";
            $pdo->exec($sql);
            echo "Tabela 'pessoas' criada com sucesso!\n";
        } catch (PDOException $e) {
            echo "Erro ao criar tabela pessoas: " . $e->getMessage();
        }
    }

    public function createTableMovimentacao() {
        try {
            $pdo = $this->connect();
            $sql = "
                CREATE TABLE IF NOT EXISTS movimentacao (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    idPessoa INT(11) NULL DEFAULT NULL,
                    Credito DECIMAL(15,2) NULL DEFAULT NULL,
                    Debito DECIMAL(15,2) NULL DEFAULT NULL,
                    DataOperacao TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                    Observacao VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
                    CreatedAt TIMESTAMP NULL DEFAULT current_timestamp(),
                    PRIMARY KEY (id) USING BTREE,
                    INDEX id (id) USING BTREE,
                    INDEX FK_ID_PESSOA (idPessoa) USING BTREE,
                    CONSTRAINT FK_ID_PESSOA FOREIGN KEY (idPessoa) REFERENCES pessoas (id) ON UPDATE NO ACTION ON DELETE NO ACTION
                ) COLLATE='utf8mb4_uca1400_ai_ci' ENGINE=InnoDB;
            ";
            $pdo->exec($sql);
            echo "Tabela 'movimentacao' criada com sucesso!\n";
        } catch (PDOException $e) {
            echo "Erro ao criar tabela movimentacao: " . $e->getMessage();
        }
    }
}
