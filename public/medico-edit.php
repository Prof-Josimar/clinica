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

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : (isset($_POST['id']) ? (int) $_POST['id'] : 0);

if ($id <= 0) {
    header('Location: /medico-list.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| GET - Carrega o médico e seus horários
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    $dados = $medicoDAO->findById($id);

    if (!$dados) {
        header('Location: /medico-list.php');
        exit;
    }

    // Horários existentes no banco
    $horarios = $medicoDAO->findHorarios($id);
}

/*
|--------------------------------------------------------------------------
| POST - Salva alterações
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome      = trim($_POST['nome'] ?? '');
    $telefone  = trim($_POST['telefone'] ?? '');
    $cpf       = trim($_POST['cpf'] ?? '');
    $endereco  = trim($_POST['endereco'] ?? '');
    $crm       = trim($_POST['crm'] ?? '');

    $especialidadesSelecionadas = $_POST['especialidades'] ?? [];
    $horariosSelecionados = $_POST['horarios'] ?? [];

    /*
    |--------------------------------------------------------------------------
    | Validação
    |--------------------------------------------------------------------------
    */
    if ($nome === '' || $cpf === '' || $crm === '') {

        $mensagem = "Nome, CPF e CRM são obrigatórios.";
        $tipoMensagem = "danger";

        // Mantém os dados digitados
        $dados = $_POST;

        /*
         * Converte especialidades para o mesmo formato
         * esperado pelo HTML.
         */
        $dados['especialidades'] = array_map(
            fn($eid) => ['id' => (int) $eid],
            $especialidadesSelecionadas
        );

        /*
         * Mantém os horários enviados pelo formulário
         * para não perder os checkboxes marcados.
         */
        $horarios = [];

        foreach ($horariosSelecionados as $dia => $turnos) {

            foreach ($turnos as $turno => $dadosTurno) {

                if (isset($dadosTurno['ativo'])) {

                    $horarios[(int) $dia][$turno] = [
                        'limite_atendimentos' =>
                            (int) ($dadosTurno['limite'] ?? 10)
                    ];
                }
            }
        }

    } else {

        /*
        |--------------------------------------------------------------------------
        | Cria objeto Médico
        |--------------------------------------------------------------------------
        */
        $medico = new Medico(
            $nome,
            $telefone ?: null,
            $cpf,
            $endereco ?: null,
            $crm
        );

        $medico->setId($id);

        /*
        |--------------------------------------------------------------------------
        | Especialidades
        |--------------------------------------------------------------------------
        */
        foreach ($especialidadesSelecionadas as $especialidadeId) {

            $especialidade = new Especialidade();

            $especialidade->setId(
                (int) $especialidadeId
            );

            $medico->addEspecialidade($especialidade);
        }

        /*
        |--------------------------------------------------------------------------
        | Atualiza médico + especialidades
        |--------------------------------------------------------------------------
        */
        if ($medicoDAO->update($medico)) {

            /*
             * Atualiza horários.
             *
             * O método primeiro apaga os horários antigos
             * e depois grava os selecionados.
             */
            if ($medicoDAO->updateHorarios(
                $id,
                $horariosSelecionados
            )) {

                $mensagem = "Médico atualizado com sucesso!";
                $tipoMensagem = "success";

            } else {

                $mensagem = "Médico atualizado, mas ocorreu um erro ao salvar os horários.";
                $tipoMensagem = "warning";
            }

        } else {

            $mensagem = "Erro ao atualizar médico.";
            $tipoMensagem = "danger";
        }

        /*
        |--------------------------------------------------------------------------
        | Recarrega os dados do banco
        |--------------------------------------------------------------------------
        */
        $dados = $medicoDAO->findById($id);

        if (!$dados) {
            header('Location: /medico-list.php');
            exit;
        }

        /*
         * Recarrega os horários do banco depois de salvar.
         */
        $horarios = $medicoDAO->findHorarios($id);
    }
}

/*
|--------------------------------------------------------------------------
| Especialidades selecionadas
|--------------------------------------------------------------------------
*/
$especialidadeIdsSelecionados = array_map(
    'intval',
    array_column(
        $dados['especialidades'] ?? [],
        'id'
    )
);

ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 700px;">

    <h2 class="mb-4">Alterar Médico</h2>

    <?php if ($mensagem): ?>

        <div class="alert alert-<?= htmlspecialchars($tipoMensagem) ?>" role="alert">
            <?= htmlspecialchars($mensagem) ?>
        </div>

    <?php endif; ?>


    <form method="POST" action="/medico-edit.php">

        <input
            type="hidden"
            name="id"
            value="<?= htmlspecialchars($id) ?>"
        >


        <!-- NOME -->

        <div class="mb-3">

            <label
                for="nome"
                class="form-label"
            >
                Nome
            </label>

            <input
                type="text"
                class="form-control"
                id="nome"
                name="nome"
                required
                maxlength="100"
                value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
            >

        </div>


        <!-- CPF / CRM -->

        <div class="row">

            <div class="col-md-6 mb-3">

                <label
                    for="cpf"
                    class="form-label"
                >
                    CPF
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="cpf"
                    name="cpf"
                    required
                    maxlength="14"
                    value="<?= htmlspecialchars($dados['cpf'] ?? '') ?>"
                >

            </div>


            <div class="col-md-6 mb-3">

                <label
                    for="crm"
                    class="form-label"
                >
                    CRM
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="crm"
                    name="crm"
                    required
                    maxlength="20"
                    value="<?= htmlspecialchars($dados['crm'] ?? '') ?>"
                >

            </div>

        </div>


        <!-- TELEFONE / ENDEREÇO -->

        <div class="row">

            <div class="col-md-6 mb-3">

                <label
                    for="telefone"
                    class="form-label"
                >
                    Telefone
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="telefone"
                    name="telefone"
                    maxlength="20"
                    value="<?= htmlspecialchars($dados['telefone'] ?? '') ?>"
                >

            </div>


            <div class="col-md-6 mb-3">

                <label
                    for="endereco"
                    class="form-label"
                >
                    Endereço
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="endereco"
                    name="endereco"
                    maxlength="150"
                    value="<?= htmlspecialchars($dados['endereco'] ?? '') ?>"
                >

            </div>

        </div>


        <!-- ESPECIALIDADES -->

        <div class="mb-3">

            <label class="form-label d-block">
                Especialidades
            </label>


            <?php if (empty($especialidadesDisponiveis)): ?>

                <p class="text-white-50">
                    Nenhuma especialidade cadastrada ainda.
                </p>

            <?php else: ?>

                <div class="row bg-white rounded p-3 text-dark">

                    <?php foreach ($especialidadesDisponiveis as $especialidade): ?>

                        <div class="col-md-4 form-check mb-2">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="especialidade<?= $especialidade['id'] ?>"
                                name="especialidades[]"
                                value="<?= $especialidade['id'] ?>"
                                <?= in_array(
                                    (int) $especialidade['id'],
                                    $especialidadeIdsSelecionados,
                                    true
                                ) ? 'checked' : '' ?>
                            >

                            <label
                                class="form-check-label"
                                for="especialidade<?= $especialidade['id'] ?>"
                            >
                                <?= htmlspecialchars($especialidade['descricao']) ?>
                            </label>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>


        <!-- DIAS E HORÁRIOS -->

        <div class="mb-4">

            <label class="form-label d-block">
                Dias e horários de atendimento
            </label>


            <?php

            $diasSemana = [
                0 => 'Domingo',
                1 => 'Segunda-feira',
                2 => 'Terça-feira',
                3 => 'Quarta-feira',
                4 => 'Quinta-feira',
                5 => 'Sexta-feira',
                6 => 'Sábado'
            ];

            $turnos = [
                'manha' => 'Manhã',
                'tarde' => 'Tarde',
                'noite' => 'Noite'
            ];

            ?>


            <div class="bg-white rounded p-3 text-dark">

                <?php foreach ($diasSemana as $diaId => $diaNome): ?>

                    <div class="border-bottom py-3">

                        <h6 class="mb-3">
                            <?= htmlspecialchars($diaNome) ?>
                        </h6>


                        <div class="row">

                            <?php foreach ($turnos as $turnoId => $turnoNome): ?>

                                <?php

                                $horario =
                                    $horarios[$diaId][$turnoId]
                                    ?? null;

                                $marcado =
                                    $horario !== null;

                                $limite =
                                    $horario['limite_atendimentos']
                                    ?? 10;

                                ?>


                                <div class="col-md-4 mb-3">

                                    <div class="form-check">

                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="dia<?= $diaId ?>_<?= $turnoId ?>"
                                            name="horarios[<?= $diaId ?>][<?= $turnoId ?>][ativo]"
                                            value="1"
                                            <?= $marcado ? 'checked' : '' ?>
                                        >

                                        <label
                                            class="form-check-label"
                                            for="dia<?= $diaId ?>_<?= $turnoId ?>"
                                        >
                                            <?= htmlspecialchars($turnoNome) ?>
                                        </label>

                                    </div>


                                    <label class="form-label small mt-2">
                                        Limite de atendimentos
                                    </label>


                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        name="horarios[<?= $diaId ?>][<?= $turnoId ?>][limite]"
                                        value="<?= $limite ?>"
                                        min="1"
                                        max="100"
                                    >

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>


        <!-- BOTÕES -->

        <button
            type="submit"
            class="btn btn-primary"
        >
            Salvar Alterações
        </button>


        <a
            href="/medico-list.php"
            class="btn btn-secondary"
        >
            Cancelar
        </a>

    </form>

</div>


<?php

$content = ob_get_clean();

require __DIR__ . '/layout.php';
