<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Medico;
use App\Models\Especialidade;
use App\DAO\MedicoDAO;
use App\DAO\EspecialidadeDAO;

$mensagem = "";
$tipoMensagem = "";

$especialidadeDAO = new EspecialidadeDAO();
$especialidadesDisponiveis = $especialidadeDAO->findAll();

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
    } else {
        $medico = new Medico($nome, $telefone ?: null, $cpf, $endereco ?: null, $crm);

        foreach ($especialidadesSelecionadas as $especialidadeId) {
            $especialidade = new Especialidade();
            $especialidade->setId((int) $especialidadeId);
            $medico->addEspecialidade($especialidade);
        }

        $dao = new MedicoDAO();
        if ($dao->insert($medico)) {
            $mensagem = "Médico cadastrado com sucesso!";
            $tipoMensagem = "success";
        } else {
            $mensagem = "Erro ao cadastrar médico.";
            $tipoMensagem = "danger";
        }
    }
}

ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 700px;">
    <h2 class="mb-4">Cadastrar Médico</h2>
        // na primera execução esta mensagem é vazia , apos um post ela é alterada no bloco acima na linha 39 ou 42 ai sim exebe algo
    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipoMensagem ?>" role="alert">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/medico-create.php">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required maxlength="100">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required maxlength="14">
            </div>
            <div class="col-md-6 mb-3">
                <label for="crm" class="form-label">CRM</label>
                <input type="text" class="form-control" id="crm" name="crm" required maxlength="20">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" maxlength="20">
            </div>
            <div class="col-md-6 mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" maxlength="150">
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
                                   value="<?= $especialidade['id'] ?>">
                            <label class="form-check-label" for="especialidade<?= $especialidade['id'] ?>">
                                <?= htmlspecialchars($especialidade['descricao']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/medico-list.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';