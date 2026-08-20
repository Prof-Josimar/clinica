<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DAO\EspecialidadeDAO;

$dao = new EspecialidadeDAO();
$especialidades = $dao->findAll();

ob_start();
?>

<div class="glass-card p-4 text-white">
    <h2 class="mb-4">Especialidades Cadastradas</h2>

    <a href="/especialidade-create.php" class="btn btn-primary mb-3">Nova Especialidade</a>

    <?php if (empty($especialidades)): ?>
        <div class="alert alert-info">Nenhuma especialidade cadastrada.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle bg-white rounded">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Sigla</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($especialidades as $especialidade): ?>
                        <tr>
                            <td><?= htmlspecialchars($especialidade['id']) ?></td>
                            <td><?= htmlspecialchars($especialidade['descricao']) ?></td>
                            <td><?= htmlspecialchars($especialidade['sigla'] ?? '-') ?></td>
                            <td>
                                <?php if ($especialidade['ativo']): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/especialidade-edit.php?id=<?= $especialidade['id'] ?>" class="btn btn-sm btn-warning">Alterar</a>
                                <a href="/especialidade-desativar.php?id=<?= $especialidade['id'] ?>" class="btn btn-sm btn-danger">
                                    <?= $especialidade['ativo'] ? 'Desativar' : 'Ativar' ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';