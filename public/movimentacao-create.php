<?php

require __DIR__ . '/../vendor/autoload.php';

use App\DAO\PessoaDAO;

$dao = new PessoaDAO();
$pessoas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $pessoas = $dao->findByNome($nome);
}

// Conteúdo da página
$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Pesquisar Pessoa</h4>
    </div>
    <div class='card-body'>
        <form method='post' class='mb-4'>
            <div class='input-group'>
                <input type='text' name='nome' class='form-control' placeholder='Digite o nome' autofocus>
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
                    <th>Movimentar</th>
                </tr>
            </thead>
            <tbody>";
foreach ($pessoas as $p) {
    $content .= "
    <tr>
        <td>{$p['id']}</td>
        <td>{$p['nome']}</td>
        <td>{$p['telefone']}</td>
        <td>{$p['cpf']}</td>
        <td>{$p['endereco']}</td>
        <td>
            <!-- Depositar -->
            <form method='post' action='movimentar.php' style='display:inline-block;'>
                <input type='hidden' name='id' value='{$p['id']}'>
                <input type='hidden' name='nome' value='{$p['nome']}'>
                <input type='hidden' name='tipo' value='credito'>
                <button type='submit' class='btn btn-success btn-sm'>Depositar</button>
            </form>

            <!-- Sacar -->
            <form method='post' action='movimentar.php' style='display:inline-block;'>
                <input type='hidden' name='id' value='{$p['id']}'>
                <input type='hidden' name='nome' value='{$p['nome']}'>
                <input type='hidden' name='tipo' value='debito'>
                <button type='submit' class='btn btn-danger btn-sm'>Sacar</button>
            </form>

            <!-- Transferir -->
            <form method='post' action='transferir.php' style='display:inline-block;'>
                <input type='hidden' name='id' value='{$p['id']}'>
                <input type='hidden' name='nome' value='{$p['nome']}'>
                <input type='hidden' name='tipo' value='transferencia'>
                <button type='submit' class='btn btn-primary btn-sm'>Transferir</button>
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
