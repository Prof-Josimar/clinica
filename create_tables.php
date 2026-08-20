<?php

require_once __DIR__ . '/src/Database.php';

use App\Database;

$db = new Database();
$db->createTablePessoas();
$db->createTableMovimentacao();
