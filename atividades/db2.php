<?php

$pdo = new PDO("mysql:host=localhost;charset=utf8mb4", "sebastian755", "755!@#");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//1-criar o banco de dados
$sql = "CREATE DATABASE IF NOT EXISTS loja_informatica";
$pdo->exec($sql);

$pdo->exec("USE loja_informatica");

//2-criar tabela categorias
$sql = "CREATE TABLE IF NOT EXISTS categorias (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL)";

$pdo->exec($sql);

//3-criar tabela produtos
$sql = "CREATE TABLE IF NOT EXISTS produtos (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(150) NOT NULL,
categoria_id INT,
preco DECIMAL(10,2) NOT NULL,
quantidade INT NOT NULL,
estoque_minimo INT NOT NULL,
FOREIGN KEY (categoria_id) REFERENCES categorias(id))";

