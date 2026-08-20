<?php
require __DIR__ . '/../vendor/autoload.php';

use App\DAO\MovimentacaoDAO;

$dao = new MovimentacaoDAO();
$resumos = $dao->getSaldosResumidos();

$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Saldos Resumidos por Pessoa</h4>
    </div>
    <div class='card-body'>
        <table class='table table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th>ID Pessoa</th>
                    <th>Nome</th>
                    <th>Saldo Atual</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>";

foreach ($resumos as $r) {
    $content .= "
        <tr>
            <td>{$r['idPessoa']}</td>
            <td>{$r['nome']}</td>
            <td>" . number_format($r['saldo'], 2, ',', '.') . "</td>
            <td>
                <form method='post' action='movimentacao-detalhe.php'>
                    <input type='hidden' name='id' value='{$r['idPessoa']}'>
                    <input type='hidden' name='nome' value='{$r['nome']}'>
                    <button type='submit' class='btn btn-info btn-sm'>Ver Extrato</button>
                </form>
            </td>
        </tr>";
}

$content .= "
            </tbody>
        </table>
    </div>
</div>
";

include "layout.php";
