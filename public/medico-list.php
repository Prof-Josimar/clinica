<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DAO\MedicoDAO;
use App\Utils\Formatter;

$dao = new MedicoDAO();

$nomePesquisa = trim($_GET['nome'] ?? '');

if ($nomePesquisa !== '') {
    $medicos = $dao->findByNome($nomePesquisa);
} else {
    $medicos = $dao->findAll();
}

ob_start();
?>

<div class="glass-card p-4 text-white">
    <h2 class="mb-4">Médicos Cadastrados</h2>

    <a href="/medico-create.php" class="btn btn-primary mb-3">Novo Médico</a>

    <form method="GET" action="/medico-list.php" class="row g-2 mb-3">
        <div class="col-auto flex-grow-1">
            <input type="text" name="nome" class="form-control" placeholder="Pesquisar por nome..."
                value="<?= htmlspecialchars($nomePesquisa) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-light">Pesquisar</button>
            <?php if ($nomePesquisa !== ''): ?>
                <a href="/medico-list.php" class="btn btn-outline-secondary">Limpar</a>
            <?php endif; ?>
        </div>
    </form>

    <?php if (empty($medicos)): ?>
        <div class="alert alert-info">
            <?= $nomePesquisa !== ''
                ? 'Nenhum médico encontrado para "' . htmlspecialchars($nomePesquisa) . '".'
                : 'Nenhum médico cadastrado.' ?>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle bg-white rounded">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CRM</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Especialidades</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicos as $medico): ?>
                        <tr>
                            <td><?= htmlspecialchars($medico['id']) ?></td>
                            <td><?= htmlspecialchars($medico['nome']) ?></td>
                            <td><?= htmlspecialchars($medico['crm']) ?></td>
                            <td><?= htmlspecialchars(Formatter::formatCpf($medico['cpf'])) ?></td>
                            <td><?= htmlspecialchars(Formatter::formatTelefone($medico['telefone'])) ?></td>
                            <td>
                                <?php if (empty($medico['especialidades'])): ?>
                                    <span class="text-muted">-</span>
                                <?php else: ?>
                                    <?php foreach ($medico['especialidades'] as $especialidade): ?>
                                        <span
                                            class="badge bg-info text-dark"><?= htmlspecialchars($especialidade['descricao']) ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/medico-horarios.php?id=<?= (int) $medico['id'] ?>" class="btn btn-sm btn-success">
                                    Plantão
                                </a>
                                <a href="/medico-edit.php?id=<?= $medico['id'] ?>" class="btn btn-sm btn-warning">Alterar</a>
                                <a href="/medico-delete.php?id=<?= $medico['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
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