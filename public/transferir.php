<?php

require __DIR__ . '/../vendor/autoload.php';

use App\DAO\PessoaDAO;

$idOrigem = $_POST['id'] ?? null;
$nomeOrigem = $_POST['nome'] ?? '';

$dao = new PessoaDAO();
$pessoas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'] ?? '';
    $pessoas = $dao->findByNome($nome);
}

// Conteúdo da página
$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Selecionar destino da transferência</h4>
        <p>Origem: {$nomeOrigem} (ID {$idOrigem})</p>
    </div>
    <div class='card-body'>
        <form method='post' class='mb-4'>
            <input type='hidden' name='id' value='{$idOrigem}'>
            <input type='hidden' name='nome' value='{$nomeOrigem}'>
            <div class='input-group'>
                <input type='text' name='nome' class='form-control' placeholder='Digite o nome do destinatário' autofocus>
                <button type='submit' class='btn btn-success'>Pesquisar</button>
            </div>
        </form>";

if (!empty($pessoas)) {
    $content .= "
        <table class='table table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Endereço</th>
                    <th>Selecionar</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($pessoas as $p) {
        // não permitir transferir para si mesmo
        if ($p['id'] == $idOrigem) continue;

        $content .= "
        <tr>
            <td>{$p['id']}</td>
            <td>{$p['nome']}</td>
            <td>{$p['telefone']}</td>
            <td>{$p['cpf']}</td>
            <td>{$p['endereco']}</td>
            <td>
                <form method='post' action='movimentar.php'>
                    <input type='hidden' name='id' value='{$idOrigem}'>
                    <input type='hidden' name='nome' value='{$nomeOrigem}'>
                    <input type='hidden' name='tipo' value='transferencia'>
                    <input type='hidden' name='destino' value='{$p['id']}'>
                    <input type='hidden' name='nomeDestino' value='{$p['nome']}'>
                    <button type='submit' class='btn btn-primary btn-sm'>Selecionar</button>
                </form>
            </td>
        </tr>";
    }

    $content .= "
            </tbody>
        </table>";
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content .= "<div class='alert alert-warning'>Nenhum resultado encontrado.</div>";
}

$content .= "</div></div>";

include "layout.php";
