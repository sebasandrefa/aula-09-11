<?php

    //PHP LINGUAGEM QUE EXECUTA AS REGRAS DO SISTEMA
    //MySQL: SGDB
    //PDO: Interface do PHP que permite conversar com o banco de dados


$host = 'localhost';
$db = 'sebastian755';
$user = 'sebastian755';
$pass =  '755!@#';
$charset = 'utf8mb4';

try{
    $pdo = new PDO ("mysql:host=$host;dbname=$db;
    charset=$charset",
    $user,
    $pass
    ); 

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    echo "Conectado com sucesso!";

} catch (PDOException $e){
    echo "ERRO AO CONECTAR AO BANCO DE DADOS.";
    echo $e->getMessage();
}
?>