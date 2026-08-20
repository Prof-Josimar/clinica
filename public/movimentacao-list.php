<?php
require __DIR__ . '/../vendor/autoload.php';

use App\DAO\MovimentacaoDAO;

$dao = new MovimentacaoDAO();
$movs = $dao->findAll();

$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Listagem de todas as movimentações</h4>
    </div>
    <div class='card-body'>
        <table class='table table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th>ID Mov.</th>
                    <th>Nome</th>
                    <th>Crédito</th>
                    <th>Débito</th>
                    <th>Data Operação</th>
                    <th>Observação</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>";

foreach ($movs as $m) {
    $content .= "
        <tr>
            <td>{$m['id']}</td>
            <td>{$m['nome']}</td>
            <td>" . number_format($m['Credito'], 2, ',', '.') . "</td>
            <td>" . number_format($m['Debito'], 2, ',', '.') . "</td>
            <td>{$m['DataOperacao']}</td>
            <td>{$m['Observacao']}</td>
            <td>
                <form method='post' action='movimentacao-detalhe.php'>
                    <input type='hidden' name='id' value='{$m['idPessoa']}'>
                    <input type='hidden' name='nome' value='{$m['nome']}'>
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
