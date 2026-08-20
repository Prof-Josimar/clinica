<?php
require __DIR__ . '/../vendor/autoload.php';

use App\DAO\MovimentacaoDAO;
use App\DAO\PessoaDAO;

$idPessoa = $_POST['id'] ?? null;

if (!$idPessoa) {
    die("<div class='alert alert-danger'>ID da pessoa não informado.</div>");
}

$pessoaDAO = new PessoaDAO();
$pessoa = $pessoaDAO->findById((int)$idPessoa);

$dao = new MovimentacaoDAO();
$saldo = $dao->getSaldo((int)$idPessoa);
$movs  = $dao->findByPessoa((int)$idPessoa);

$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Extrato de {$pessoa['nome']} (ID {$idPessoa})</h4>
    </div>
    <div class='card-body'>
        <h5>Saldo atual: R$ " . number_format($saldo, 2, ',', '.') . "</h5>
        <hr>
        <table class='table table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Crédito</th>
                    <th>Débito</th>
                    <th>Data Operação</th>
                    <th>Observação</th>
                </tr>
            </thead>
            <tbody>";

foreach ($movs as $m) {
    $content .= "
        <tr>
            <td>{$m['id']}</td>
            <td>" . number_format($m['Credito'], 2, ',', '.') . "</td>
            <td>" . number_format($m['Debito'], 2, ',', '.') . "</td>
            <td>{$m['DataOperacao']}</td>
            <td>{$m['Observacao']}</td>
        </tr>";
}

$content .= "
            </tbody>
        </table>
    </div>
</div>
";

include "layout.php";
