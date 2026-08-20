<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DAO\MedicoDAO;
use App\Utils\Formatter;

$dao = new MedicoDAO();
$mensagem = "";
$tipoMensagem = "";

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);

if ($id <= 0) {
    header('Location: /medico-list.php');
    exit;
}

$dados = $dao->findById($id);

if (!$dados) {
    header('Location: /medico-list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($dao->delete($id)) {
        header('Location: /medico-list.php?excluido=1');
        exit;
    } else {
        $mensagem = "Erro ao excluir médico.";
        $tipoMensagem = "danger";
    }
}

ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 600px;">
    <h2 class="mb-4">Excluir Médico</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem ?>" role="alert">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <table class="table table-borderless text-white">
        <tr>
            <th>Nome</th>
            <td><?= htmlspecialchars($dados['nome']) ?></td>
        </tr>
        <tr>
            <th>CRM</th>
            <td><?= htmlspecialchars($dados['crm']) ?></td>
        </tr>
        <tr>
            <th>CPF</th>
            <td><?= htmlspecialchars(Formatter::formatCpf($dados['cpf'])) ?></td>
        </tr>
        <tr>
            <th>Especialidades</th>
            <td>
                <?php if (empty($dados['especialidades'])): ?>
                    -
                <?php else: ?>
                    <?php foreach ($dados['especialidades'] as $especialidade): ?>
                        <span class="badge bg-info text-dark"><?= htmlspecialchars($especialidade['descricao']) ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <form method="POST" action="/medico-delete.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <p>Tem certeza que deseja <strong>excluir</strong> este médico? Essa ação não pode ser desfeita.</p>

        <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
        <a href="/medico-list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';