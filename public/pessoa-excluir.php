<?php

require __DIR__ . '/../vendor/autoload.php';

use App\DAO\PessoaDAO;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $dao = new PessoaDAO();

    if ($dao->delete($id)) {
        echo "<script>
                alert('Pessoa excluída com sucesso!');
                window.location='pessoa-listar.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao excluir pessoa!');
                window.location='pessoa-listar.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Nenhum ID informado!');
            window.location='pessoa-listar.php';
          </script>";
}
