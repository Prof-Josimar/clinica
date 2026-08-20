<?php

require __DIR__ . '/../vendor/autoload.php';

use App\DAO\PessoaDAO;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $dao = new PessoaDAO();
    $pessoa = $dao->findById($id);

    if ($pessoa) {
        $content = "
        <div class='card shadow'>
            <div class='card-header bg-info text-white'>
                <h4>Detalhes da Pessoa</h4>
            </div>
            <div class='card-body'>
                <ul class='list-group'>
                    <li class='list-group-item'><strong>ID:</strong> {$pessoa['id']}</li>
                    <li class='list-group-item'><strong>Nome:</strong> {$pessoa['nome']}</li>
                    <li class='list-group-item'><strong>Telefone:</strong> {$pessoa['telefone']}</li>
                    <li class='list-group-item'><strong>CPF:</strong> {$pessoa['cpf']}</li>
                    <li class='list-group-item'><strong>Endereço:</strong> {$pessoa['endereco']}</li>
                </ul>
                <div class='mt-3'>
                    <a href='pessoa-listar.php' class='btn btn-secondary'>Voltar</a>
                </div>
            </div>
        </div>";
    } else {
        $content = "<div class='alert alert-danger'>Pessoa não encontrada!</div>";
    }
} else {
    $content = "<div class='alert alert-warning'>Nenhum ID informado.</div>";
}

include "layout.php";
