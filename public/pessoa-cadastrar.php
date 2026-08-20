<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Pessoa;
use App\DAO\PessoaDAO;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $nome = mb_strtoupper($nome, 'UTF-8');
    // ou em uma linha : $nome = mb_strtoupper($_POST['nome'] ?? '', 'UTF-8');

    $telefone = $_POST['telefone'] ?? null;
    $cpf = $_POST['cpf'] ?? '';
    
    $endereco = $_POST['endereco'] ?? null;
    $endereco = mb_strtoupper($endereco, 'UTF-8');


    $pessoa = new Pessoa($nome, $telefone, $cpf, $endereco);
    $dao = new PessoaDAO();


    if ($dao->insert($pessoa)) {

        echo "<script>
                alert('Dados salvos com sucesso!');
                window.location='pessoa-create.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao salvar dados!');
                window.location='pessoa-create.php';
              </script>";
    }


}
