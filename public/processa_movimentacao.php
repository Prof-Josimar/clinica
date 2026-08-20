<?php
// processa_movimentacao.php
require __DIR__ . '/../vendor/autoload.php';

use App\DAO\PessoaDAO;
use App\DAO\MovimentacaoDAO;

$idPessoa   = $_POST['id'] ?? null;
$nome       = $_POST['nome'] ?? '';
$tipo       = $_POST['tipo'] ?? '';

$pessoaDAO = new PessoaDAO();
$movDAO    = new MovimentacaoDAO();

// Carrega lista de pessoas para o select
$pessoas = $pessoaDAO->findAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valor'])) {
    $valor      = (float) $_POST['valor'];
    $observacao = $_POST['observacao'] ?? '';
    $destino    = $_POST['destino'] ?? null;

    if ($tipo === 'transferencia' && $destino) {
        // Débito na origem
        $movDAO->insert([
            'idPessoa'   => $idPessoa,
            'Credito'    => 0.00,
            'Debito'     => $valor,
            'Observacao' => 'Tranferencia Via Sistema'
        ]);

        // Crédito no destino
        $movDAO->insert([
            'idPessoa'   => $destino,
            'Credito'    => $valor,
            'Debito'     => 0.00,
            'Observacao' => 'Recebimento de Tranf Via Sistema'
        ]);

        $mensagem = "<div class='alert alert-success'>Transferência realizada com sucesso!</div>";
    } else {
        // Operações simples de crédito ou débito
        $credito = $tipo === 'credito' ? $valor : 0.00;
        $debito  = $tipo === 'debito'  ? $valor : 0.00;

        $movDAO->insert([
            'idPessoa'   => $idPessoa,
            'Credito'    => $credito,
            'Debito'     => $debito,
            'Observacao' => $observacao
        ]);

        $mensagem = "<div class='alert alert-success'>Movimentação registrada com sucesso!</div>";
    }
}
?>

<?php
// Conteúdo da página
$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Registrar movimentação para: {$nome} (ID {$idPessoa})</h4>
    </div>
    <div class='card-body'>
        " . ($mensagem ?? '') . "
        <form method='post'>
            <input type='hidden' name='id' value='{$idPessoa}'>
            <input type='hidden' name='nome' value='{$nome}'>
            <input type='hidden' name='tipo' value='{$tipo}'>

            <div class='mb-3'>
                <label for='valor' class='form-label'>Valor</label>
                <input type='number' step='0.01' name='valor' id='valor' class='form-control' required  autofocus>
            </div>";

if ($tipo === 'transferencia') {
    $content .= "
            <div class='mb-3'>
                <label for='destino' class='form-label'>Pessoa Destino</label>
                <select name='destino' id='destino' class='form-select' required>
                    <option value=''>Selecione...</option>";
    foreach ($pessoas as $p) {
        if ($p['id'] != $idPessoa) { // não listar a própria pessoa
            $content .= "<option value='{$p['id']}'>{$p['nome']} (ID {$p['id']})</option>";
        }
    }
    $content .= "</select>
            </div>";
}

$content .= "
            <div class='mb-3'>
                <label for='observacao' class='form-label'>Observação</label>
                <input type='text' name='observacao' id='observacao' class='form-control' value=''>
            </div>

            <button type='submit' class='btn btn-success'>Gravar</button>
        </form>
    </div>
</div>
";

include "layout.php";
