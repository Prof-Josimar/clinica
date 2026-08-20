<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Especialidade;
use App\DAO\EspecialidadeDAO;

$dao = new EspecialidadeDAO();
$mensagem = "";
$tipoMensagem = "";

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if ($id <= 0) {
    header('Location: /especialidade-list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $descricao = trim($_POST['descricao'] ?? '');
    $sigla     = trim($_POST['sigla'] ?? '');
    $ativo     = isset($_POST['ativo']) ? true : false;

    if ($descricao === '') {
        $mensagem = "A descrição é obrigatória.";
        $tipoMensagem = "danger";
        $dados = $_POST;
    } else {
        $especialidade = new Especialidade($descricao, $sigla ?: null, $ativo);
        $especialidade->setId($id);

        if ($dao->update($especialidade)) {
            $mensagem = "Especialidade atualizada com sucesso!";
            $tipoMensagem = "success";
        } else {
            $mensagem = "Nenhuma alteração foi realizada.";
            $tipoMensagem = "warning";
        }
        $dados = $dao->findById($id);
    }
} else {
    $dados = $dao->findById($id);

    if (!$dados) {
        header('Location: /especialidade-list.php');
        exit;
    }
}

ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 600px;">
    <h2 class="mb-4">Alterar Especialidade</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem ?>" role="alert">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/especialidade-edit.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" required maxlength="100"
                   value="<?= htmlspecialchars($dados['descricao'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="sigla" class="form-label">Sigla</label>
            <input type="text" class="form-control" id="sigla" name="sigla" maxlength="10"
                   value="<?= htmlspecialchars($dados['sigla'] ?? '') ?>">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="ativo" name="ativo"
                   <?= !empty($dados['ativo']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="ativo">Ativo</label>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/especialidade-list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';