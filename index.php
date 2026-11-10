<?php

require_once 'conexao.php';
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
id INT AUTO_INCRIMENT PRIMARY KEY,
nome VARCHAR (100) NOT NULL,
email VARCHAR (50) UNIQUE NOT NULL,
telefone VARCHAR (20) UNIQUE NOT NULL,
ativo BOOLEAN DEFAULT 1,
data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
)
";

//PREPARANDO  COMANDO  SQL
//stmt = statment
$stmt = pdo->prepare($sql);

//EXECUTAR  O  COMANDO
$stmt->execute();

//MESAGEM  DE  SUCESSO
echo "Tabela criada ou já existente!";

?>