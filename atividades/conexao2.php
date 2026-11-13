<?php

$host = 'localhost';
$db = 'loja_informatica';
$user = 'sebastian755';
$pass =  '755!@#';
$charset = 'utf8mb4';
$pdo = null;

try{
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

} catch (Throwable $e){
    error_log($e->getMessage());
    $pdo = null;
}
?>