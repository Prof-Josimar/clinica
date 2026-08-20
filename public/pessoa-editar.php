<?php

require __DIR__ . '/../vendor/autoload.php';

use App\DAO\PessoaDAO;
use App\Models\Pessoa;

$dao = new PessoaDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    // Se for atualização (form enviado com nome)
    if (isset($_POST['nome'])) {
        $nome = $_POST['nome'] ?? '';
        $telefone = $_POST['telefone'] ?? null;
        $cpf = $_POST['cpf'] ?? '';
        $endereco = $_POST['endereco'] ?? null;

        // cria objeto com dados do formulário
        $pessoa = new Pessoa($nome, $telefone, $cpf, $endereco);
        $pessoa->setId($id); // agora sim, id é setado

        if ($dao->update($pessoa)) {
            echo "<script>
                    alert('Dados atualizados com sucesso!');
                    window.location='pessoa-listar.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Nenhuma alteração realizada ou ID inexistente!');
                    window.location='pessoa-listar.php';
                  </script>";
            exit;
        }
    }

    // Se for apenas carregar os dados para edição
    $pessoa = $dao->findById($id);

    if ($pessoa) {
        $content = "
        <div class='card shadow'>
            <div class='card-header bg-warning text-dark'>
                <h4>Editar Pessoa</h4>
            </div>
            <div class='card-body'>
                <form method='post'>
                    <input type='hidden' name='id' value='{$pessoa['id']}'>
                    
                    <div class='mb-3'>
                        <label class='form-label'>Nome</label>
                        <input type='text' name='nome' class='form-control' value='{$pessoa['nome']}' required autofocus  autofocus>
                    </div>
                    
                    <div class='mb-3'>
                        <label class='form-label'>Telefone</label>
                        <input type='text' name='telefone' class='form-control' value='{$pessoa['telefone']}'>
                    </div>
                    
                    <div class='mb-3'>
                        <label class='form-label'>CPF</label>
                        <input type='text' name='cpf' class='form-control' value='{$pessoa['cpf']}' required>
                    </div>
                    
                    <div class='mb-3'>
                        <label class='form-label'>Endereço</label>
                        <textarea name='endereco' class='form-control'>{$pessoa['endereco']}</textarea>
                    </div>
                    
                    <button type='submit' class='btn btn-success'>Salvar</button>
                    <a href='pessoa-listar.php' class='btn btn-secondary'>Cancelar</a>
                </form>
            </div>
        </div>";
    } else {
        $content = "<div class='alert alert-danger'>Pessoa não encontrada!</div>";
    }
} else {
    $content = "<div class='alert alert-warning'>Nenhum ID informado.</div>";
}

include "layout.php";
