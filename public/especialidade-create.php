<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Especialidade;
use App\DAO\EspecialidadeDAO;

$mensagem = "";
$tipoMensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $descricao = trim($_POST['descricao'] ?? '');
    $sigla     = trim($_POST['sigla'] ?? '');
    $ativo     = isset($_POST['ativo']) ? true : false;

    if ($descricao === '') {
        $mensagem = "A descrição é obrigatória.";
        $tipoMensagem = "danger";
    } else {
        $especialidade = new Especialidade($descricao, $sigla ?: null, $ativo);

        $dao = new EspecialidadeDAO();
        if ($dao->insert($especialidade)) {
            $mensagem = "Especialidade cadastrada com sucesso!";
            $tipoMensagem = "success";
        } else {
            $mensagem = "Erro ao cadastrar especialidade.";
            $tipoMensagem = "danger";
        }
    }
}

ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 600px;">
    <h2 class="mb-4">Cadastrar Especialidade</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem ?>" role="alert">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/especialidade-create.php">
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" required maxlength="100">
        </div>

        <div class="mb-3">
            <label for="sigla" class="form-label">Sigla</label>
            <input type="text" class="form-control" id="sigla" name="sigla" maxlength="10">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="ativo" name="ativo" checked>
            <label class="form-check-label" for="ativo">Ativo</label>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/especialidade-list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';