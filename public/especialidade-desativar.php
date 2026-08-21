<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Especialidade;
use App\DAO\EspecialidadeDAO;

$dao = new EspecialidadeDAO();
$mensagem = "";
$tipoMensagem = "";

//$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
// comentei p operador ternario aninhado anterior para usar if else aninhado por legibilidade
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
} else {
    $id = 0;
}


if ($id <= 0) {
    header('Location: /especialidade-list.php');
    exit;
}

$dados = $dao->findById($id);

if (!$dados) {
    header('Location: /especialidade-list.php');
    exit;
}

// Confirmação via POST: alterna o status (ativo <-> inativo)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $novoStatus = !$dados['ativo'];

    $especialidade = new Especialidade($dados['descricao'], $dados['sigla'], $novoStatus);
    $especialidade->setId($id);

    if ($dao->update($especialidade)) {
        $mensagem = $novoStatus
            ? "Especialidade ativada com sucesso!"
            : "Especialidade desativada com sucesso!";
        $tipoMensagem = "success";
    } else {
        $mensagem = "Erro ao atualizar o status da especialidade.";
        $tipoMensagem = "danger";
    }

    // Recarrega os dados atualizados
    $dados = $dao->findById($id);
}

ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 600px;">
    <h2 class="mb-4"><?= $dados['ativo'] ? 'Desativar' : 'Ativar' ?> Especialidade</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem ?>" role="alert">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <table class="table table-borderless text-white">
        <tr>
            <th>Descrição</th>
            <td><?= htmlspecialchars($dados['descricao']) ?></td>
        </tr>
        <tr>
            <th>Sigla</th>
            <td><?= htmlspecialchars($dados['sigla'] ?? '-') ?></td>
        </tr>
        <tr>
            <th>Status atual</th>
            <td>
                <?php if ($dados['ativo']): ?>
                    <span class="badge bg-success">Ativo</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Inativo</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <form method="POST" action="/especialidade-desativar.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <p>Tem certeza que deseja <strong><?= $dados['ativo'] ? 'desativar' : 'ativar' ?></strong> esta especialidade?</p>

        <button type="submit" class="btn <?= $dados['ativo'] ? 'btn-danger' : 'btn-success' ?>">
            Confirmar <?= $dados['ativo'] ? 'Desativação' : 'Ativação' ?>
        </button>
        <a href="/especialidade-list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';