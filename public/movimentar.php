<?php
require __DIR__ . '/../vendor/autoload.php';

use App\DAO\MovimentacaoDAO;

$idOrigem   = $_POST['id'] ?? null;
$nomeOrigem = $_POST['nome'] ?? '';
$tipo       = $_POST['tipo'] ?? '';
$idDestino  = $_POST['destino'] ?? null;
$nomeDestino= $_POST['nomeDestino'] ?? '';

$movDAO = new MovimentacaoDAO();

// Observação padrão
switch ($tipo) {
    case 'credito':
        $observacaoPadrao = 'Deposito Via Sistema';
        break;
    case 'debito':
        $observacaoPadrao = 'Saque Via Sistema';
        break;
    case 'transferencia':
        $observacaoPadrao = 'Tranferencia Via Sistema';
        break;
    default:
        $observacaoPadrao = '';
}



// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valor'])) {
    $valor      = (float) $_POST['valor'];
    $observacao = $_POST['observacao'] ?? $observacaoPadrao;

    if ($tipo === 'transferencia' && $idDestino) {
        // Débito na origem
        $movDAO->insert([
            'idPessoa'   => $idOrigem,
            'Credito'    => 0.00,
            'Debito'     => $valor,
            'Observacao' => 'Tranferencia Via Sistema'
        ]);

        // Crédito no destino
        $movDAO->insert([
            'idPessoa'   => $idDestino,
            'Credito'    => $valor,
            'Debito'     => 0.00,
            'Observacao' => 'Recebimento de Tranf Via Sistema'
        ]);

        $mensagem = "<div class='alert alert-success'>Transferência realizada com sucesso!</div>";
    } else {
        if ($valor > 0) {
            $credito = $tipo === 'credito' ? $valor : 0.00;
            $debito  = $tipo === 'debito'  ? $valor : 0.00;

            $movDAO->insert([
                'idPessoa'   => $idOrigem,
                'Credito'    => $credito,
                'Debito'     => $debito,
                'Observacao' => $observacao
            ]);

            $mensagem = "<div class='alert alert-success'>Movimentação registrada com sucesso!</div>";
        }
    }
}

// Conteúdo da página
$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Registrar movimentação</h4>
        <p>Origem: {$nomeOrigem}  (ID {$idOrigem})</p>";
if ($tipo === 'transferencia' && $idDestino) {
    $content .= "<p>Destino: {$nomeDestino} (ID {$idDestino})</p>";
}
$content .= "</div>
    <div class='card-body'>
        " . ($mensagem ?? '') . "
        <form method='post'>
            <input type='hidden' name='id' value='{$idOrigem}'>
            <input type='hidden' name='nome' value='{$nomeOrigem}'>
            <input type='hidden' name='tipo' value='{$tipo}'>
            <input type='hidden' name='destino' value='{$idDestino}'>
            <input type='hidden' name='nomeDestino' value='{$nomeDestino}'>

            <div class='mb-3'>
                <label for='valor' class='form-label'>Valor</label>
                <input type='number' step='0.01' name='valor' id='valor' class='form-control' required autofocus>
            </div>

            <div class='mb-3'>
                <label for='observacao' class='form-label'>Observação</label>
                <input type='text' name='observacao' id='observacao' class='form-control' value='{$observacaoPadrao}'>
            </div>

            <button type='submit' class='btn btn-success'>Gravar</button>
        </form>
    </div>
</div>
";

include "layout.php";
