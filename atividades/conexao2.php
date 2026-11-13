<?php

$host = 'localhost';
$db = 'sebastian755';
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