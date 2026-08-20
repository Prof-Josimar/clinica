<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Medico;
use App\Models\Especialidade;
use App\DAO\MedicoDAO;
use App\DAO\EspecialidadeDAO;

$medicoDAO = new MedicoDAO();
$especialidadeDAO = new EspecialidadeDAO();
$especialidadesDisponiveis = $especialidadeDAO->findAll();

$mensagem = "";
$tipoMensagem = "";

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);

if ($id <= 0) {
    header('Location: /medico-list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome      = trim($_POST['nome'] ?? '');
    $telefone  = trim($_POST['telefone'] ?? '');
    $cpf       = trim($_POST['cpf'] ?? '');
    $endereco  = trim($_POST['endereco'] ?? '');
    $crm       = trim($_POST['crm'] ?? '');
    $especialidadesSelecionadas = $_POST['especialidades'] ?? [];

    if ($nome === '' || $cpf === '' || $crm === '') {
        $mensagem = "Nome, CPF e CRM são obrigatórios.";
        $tipoMensagem = "danger";
        $dados = $_POST;
        $dados['especialidades'] = array_map(fn($eid) => ['id' => (int) $eid], $especialidadesSelecionadas);
    } else {
        $medico = new Medico($nome, $telefone ?: null, $cpf, $endereco ?: null, $crm);
        $medico->setId($id);

        foreach ($especialidadesSelecionadas as $especialidadeId) {
            $especialidade = new Especialidade();
            $especialidade->setId((int) $especialidadeId);
            $medico->addEspecialidade($especialidade);
        }

        if ($medicoDAO->update($medico)) {
            $mensagem = "Médico atualizado com sucesso!";
            $tipoMensagem = "success";
        } else {
            $mensagem = "Erro ao atualizar médico.";
            $tipoMensagem = "danger";
        }
        $dados = $medicoDAO->findById($id);
    }
} else {
    $dados = $medicoDAO->findById($id);

    if (!$dados) {
        header('Location: /medico-list.php');
        exit;
    }
}

$especialidadeIdsSelecionados = array_column($dados['especialidades'] ?? [], 'id');

ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 700px;">
    <h2 class="mb-4">Alterar Médico</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem ?>" role="alert">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/medico-edit.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required maxlength="100"
                   value="<?= htmlspecialchars($dados['nome'] ?? '') ?>">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required maxlength="14"
                       value="<?= htmlspecialchars($dados['cpf'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="crm" class="form-label">CRM</label>
                <input type="text" class="form-control" id="crm" name="crm" required maxlength="20"
                       value="<?= htmlspecialchars($dados['crm'] ?? '') ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" maxlength="20"
                       value="<?= htmlspecialchars($dados['telefone'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" maxlength="150"
                       value="<?= htmlspecialchars($dados['endereco'] ?? '') ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Especialidades</label>

            <?php if (empty($especialidadesDisponiveis)): ?>
                <p class="text-white-50">Nenhuma especialidade cadastrada ainda.</p>
            <?php else: ?>
                <div class="row bg-white rounded p-3 text-dark">
                    <?php foreach ($especialidadesDisponiveis as $especialidade): ?>
                        <div class="col-md-4 form-check mb-2">
                            <input type="checkbox"
                                   class="form-check-input"
                                   id="especialidade<?= $especialidade['id'] ?>"
                                   name="especialidades[]"
                                   value="<?= $especialidade['id'] ?>"
                                   <?= in_array($especialidade['id'], $especialidadeIdsSelecionados) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="especialidade<?= $especialidade['id'] ?>">
                                <?= htmlspecialchars($especialidade['descricao']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/medico-list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';