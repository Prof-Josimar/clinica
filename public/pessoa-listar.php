<?php

require __DIR__ . '/../vendor/autoload.php';

use App\DAO\PessoaDAO;


$dao = new PessoaDAO();
$pessoas = $dao->findAll();

$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Lista de Pessoas</h4>
    </div>
    <div class='card-body'>
        <table class='table table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>";
            
foreach ($pessoas as $p) {
    $content .= "
        <tr>
            <td>{$p['id']}</td>
            <td>{$p['nome']}</td>
            <td>{$p['telefone']}</td>
            <td>{$p['cpf']} </td>
            <td>{$p['endereco']}</td>
            <td class='d-flex gap-2'>
                <!-- Detalhes -->
                <form action='pessoa-detalhes.php' method='post'>
                    <input type='hidden' name='id' value='{$p['id']}'>
                    <button type='submit' class='btn btn-info btn-sm'>Detalhes</button>
                </form>

                <!-- Editar -->
                <form action='pessoa-editar.php' method='post'>
                    <input type='hidden' name='id' value='{$p['id']}'>
                    <button type='submit' class='btn btn-warning btn-sm'>Editar</button>
                </form>

                <!-- Excluir -->
                <form action='pessoa-excluir.php' method='post' onsubmit=\"return confirm('Tem certeza que deseja excluir esta pessoa?');\">
                    <input type='hidden' name='id' value='{$p['id']}'>
                    <button type='submit' class='btn btn-danger btn-sm'>Excluir</button>
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
