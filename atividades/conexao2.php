<?php

require_once 'conexao2.php';

$host = 'localhost';
$banco = 'loja_informatica';
$usuario = 'sebastian755';
$senha = '755!@#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco
    ;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, 
    PDO::ERRMODE_EXCEPTION);
}
?>