<?php

namespace App\DAO;

use App\Models\Medico;
use App\Database;
use PDO;

class MedicoDAO
{

    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // INSERT (médico + especialidades na tabela pivô, tudo em uma transação)
    public function insert(Medico $medico): bool
    {
        try {
            $this->conn->beginTransaction();

            $sql = "INSERT INTO medicos (nome, telefone, cpf, endereco, crm) 
                    VALUES (:nome, :telefone, :cpf, :endereco, :crm)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nome' => $medico->getNome(),
                ':telefone' => $medico->getTelefone(),
                ':cpf' => $medico->getCpf(),
                ':endereco' => $medico->getEndereco(),
                ':crm' => $medico->getCrm()
            ]);

            $medicoId = (int) $this->conn->lastInsertId();
            $medico->setId($medicoId);

            $this->salvarEspecialidades($medicoId, $medico->getEspecialidadeIds());

            $this->conn->commit();
            return true;

        } catch (\Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Grava os vínculos na tabela pivô medico_especialidade
    private function salvarEspecialidades(int $medicoId, array $especialidadeIds): void
    {
        // Remove vínculos antigos (útil também no update)
        $sql = "DELETE FROM medico_especialidade WHERE medico_id = :medico_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':medico_id' => $medicoId]);

        if (empty($especialidadeIds)) {
            return;
        }

        $sql = "INSERT INTO medico_especialidade (medico_id, especialidade_id) VALUES (:medico_id, :especialidade_id)";
        $stmt = $this->conn->prepare($sql);

        foreach ($especialidadeIds as $especialidadeId) {
            $stmt->execute([
                ':medico_id' => $medicoId,
                ':especialidade_id' => (int) $especialidadeId
            ]);
        }
    }

    // LISTAR TODOS (com especialidades já carregadas)
    public function findAll(): array
    {
        $sql = "SELECT id, nome, telefone, cpf, endereco, crm, created_at, updated_at FROM medicos";
        $stmt = $this->conn->query($sql);
        $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($medicos as &$medico) {
            $medico['especialidades'] = $this->buscarEspecialidadesDoMedico($medico['id']);
        }

        return $medicos;
    }

    // BUSCAR POR ID (com especialidades)
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM medicos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $medico = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$medico) {
            return null;
        }

        $medico['especialidades'] = $this->buscarEspecialidadesDoMedico($id);
        return $medico;
    }

    // Retorna as especialidades vinculadas a um médico
    private function buscarEspecialidadesDoMedico(int $medicoId): array
    {
        $sql = "SELECT e.id, e.descricao, e.sigla 
                FROM especialidades e
                INNER JOIN medico_especialidade me ON me.especialidade_id = e.id
                WHERE me.medico_id = :medico_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':medico_id' => $medicoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE (médico + especialidades)
    public function update(Medico $medico): bool
    {
        try {
            $this->conn->beginTransaction();

            $sql = "UPDATE medicos 
                    SET nome = :nome, telefone = :telefone, cpf = :cpf, endereco = :endereco, crm = :crm 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nome' => $medico->getNome(),
                ':telefone' => $medico->getTelefone(),
                ':cpf' => $medico->getCpf(),
                ':endereco' => $medico->getEndereco(),
                ':crm' => $medico->getCrm(),
                ':id' => $medico->getId()
            ]);

            $this->salvarEspecialidades($medico->getId(), $medico->getEspecialidadeIds());

            $this->conn->commit();
            return true;

        } catch (\Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // DELETE (a tabela pivô já remove sozinha via ON DELETE CASCADE)
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM medicos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }



// PESQUISAR POR NOME (com especialidades já carregadas)
public function findByNome(string $nome): array
{
    $sql = "SELECT id, nome, telefone, cpf, endereco, crm, created_at, updated_at 
            FROM medicos 
            WHERE nome LIKE :nome";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':nome' => "%$nome%"]);
    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($medicos as &$medico) {
        $medico['especialidades'] = $this->buscarEspecialidadesDoMedico($medico['id']);
    }

    return $medicos;
}

}