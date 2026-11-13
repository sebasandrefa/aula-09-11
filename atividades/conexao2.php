<?php

// Conexao com o banco de dados usando PDO
// No XAMPP o usuario padrao e "root" e a senha e vazia

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