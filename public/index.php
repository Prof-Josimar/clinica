<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database;

// Conexão com banco
/*
Aqui você está criando uma instância da classe Database.
Essa classe provavelmente encapsula as configurações de conexão (host, usuário, senha, banco).
*/
$db = new Database();

/*
método connect() retorna o objeto de conexão (geralmente um PDO).
Esse objeto é o que guarda as "credenciais" e permite executar queries no banco.
*/
$conn = $db->connect();

/*
Aqui você usa o objeto de conexão para executar uma query SQL.
O método query() retorna um objeto PDOStatement, que representa a declaração preparada e já executada.
*/
$stmt = $conn->query("SELECT DATE_FORMAT(NOW(), '%d/%m/%Y %H:%i:%s')");

/*
Como a query retorna apenas uma linha e uma coluna (a hora formatada), fetchColumn() pega diretamente esse valor.
O resultado é armazenado na variável $horaAtual
*/
$horaAtual = $stmt->fetchColumn();


// Definindo o conteúdo da página

$content = "
<div class='d-flex justify-content-center align-items-center' style='height:70vh;'>
    <div class='card text-center p-4 glass-card'>
        <h2 class='mb-3 text-light'>💸 Sistema de Finanças 💰</h2>
        <p class='fs-5 text-light'><br><i>
           Conexão bem-sucedida! 👌</i><br><hr>
            Hora atual do MySQL: <strong>{$horaAtual}</strong>
        </p>
    </div>
</div>
";




// Inclui o layout (que usa $content)
include "layout.php";
