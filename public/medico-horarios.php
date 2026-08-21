<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DAO\MedicoDAO;

$dao = new MedicoDAO();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: /medico-list.php');
    exit;
}


// Busca o médico
$medico = $dao->findById($id);

if (!$medico) {
    header('Location: /medico-list.php');
    exit;
}


// Busca os horários
$horarios = $dao->findHorarios($id);


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


ob_start();
?>

<div class="glass-card p-4 text-white mx-auto" style="max-width: 900px;">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Plantões do Médico
            </h2>

            <div class="text-white-50">
                <?= htmlspecialchars($medico['nome']) ?>
            </div>

            <div class="text-white-50">
                CRM: <?= htmlspecialchars($medico['crm']) ?>
            </div>
        </div>

        <a href="/medico-list.php" class="btn btn-secondary">
            Voltar
        </a>

    </div>


    <?php if (empty($horarios)): ?>

        <div class="alert alert-info">
            Este médico não possui horários de plantão cadastrados.
        </div>

    <?php else: ?>

        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle bg-white rounded">

                <thead class="table-dark">

                    <tr>
                        <th>Dia</th>
                        <th>Turno</th>
                        <th>Limite de atendimentos</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($diasSemana as $diaId => $diaNome): ?>

                        <?php if (!empty($horarios[$diaId])): ?>

                            <?php foreach ($turnos as $turnoId => $turnoNome): ?>

                                <?php if (isset($horarios[$diaId][$turnoId])): ?>

                                    <?php
                                    $horario = $horarios[$diaId][$turnoId];
                                    ?>

                                    <tr>

                                        <td>
                                            <strong>
                                                <?= $diaNome ?>
                                            </strong>
                                        </td>

                                        <td>

                                            <?php
                                            $classeTurno = match ($turnoId) {
                                                'manha' => 'bg-warning text-dark',
                                                'tarde' => 'bg-info text-dark',
                                                'noite' => 'bg-dark text-white',
                                                default => 'bg-secondary'
                                            };
                                            ?>

                                            <span class="badge <?= $classeTurno ?>">
                                                <?= $turnoNome ?>
                                            </span>

                                        </td>

                                        <td>
                                            <?= (int) $horario['limite_atendimentos'] ?>
                                        </td>

                                    </tr>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>


<?php

$content = ob_get_clean();

require __DIR__ . '/layout.php';
