<?php

//if verifica se o formulario foi enviado usando o metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    // recebe as notas de prtgs
    $portugues_prova1 = $_POST["portugues_prova1"];
    $portugues_prova2 = $_POST["portugues_prova2"];
    $portugues_prova3 = $_POST["portugues_prova3"];

    // recebe as notas de matematica
    $matematica_prova1 = $_POST["matematica_prova1"];
    $matematica_prova2 = $_POST["matematica_prova2"];
    $matematica_prova3 = $_POST["matematica_prova3"];

    // recebe as notas de historia
    $historia_prova1 = $_POST["historia_prova1"];
    $historia_prova2 = $_POST["historia_prova2"];
    $historia_prova3 = $_POST["historia_prova3"];

    $novoAluno = [
        "nome" => $nome,
        "idade" => $idade,
        "notas" => [
            "portugues" => [
                "prova1" => $portugues_prova1,
                "prova2" => $portugues_prova2,
                "prova3" => $portugues_prova3,
            ],

            "matematica" => [
                "prova1" => $matematica_prova1,
                "prova2" => $matematica_prova2,
                "prova3" => $matematica_prova3,
            ],

            "historia" => [
                "prova1" => $historia_prova1,
                "prova2" => $historia_prova2,
                "prova3" => $historia_prova3,
            ]

        ]
    ];

    //serve pra ler/abrir arquivo json
    $conteudoJson = file_get_contents(__DIR__ . "../dados/intro.json");

    // serve para converter json para array php
    //o (true) serve para converter o json em array associativo para php ler
    $alunos = json_decode($conteudoJson, true);

    //adicionar novo aluno
    $alunos[] = $novoAluno;

    //CONVERTER O ARRAY PHP PARA JSON
    $jsonAtualizado = json_encode(
        $alunos,
        //json pretty print deixa o json bonito pulando linhas
        //json unescaped unicode serve pros carateres especiais do portuges joao = jou00e30o
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    //salvar no arquivo json
    file_put_contents(__DIR__ . "../dados/intro.json", $jsonAtualizado);
}

//ler dados para exibir

//lee el archuivo JSON
$conteudoJson = file_get_contents(__DIR__ . "../dados/intro.json");

//converte o json para array php
$alunos = json_decode($conteudoJson, true);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dados-json</title>
    <link rel="stylesheet" href="../css/02-dados-json.css">
</head>
<header>
    <div class="logo">
        <h2>José <span>Oropesa</span></h2>
    </div>
    <nav>
        <a href="../index.php">Inicio</a>
        <a href="../index.php#sobre">Sobre</a>
        <a href="../index.php#projetos">Projetos</a>
        <a href="../index.php#contato">Contato</a>
        
    </nav>
    </header>

<body>
    <h1>CADASTRO DE NOTAS</h1>
    <form method="POST">
        <label">Nome:</label>
            <input type="text" name="nome" required>
            <br><br>
            <label">Idade:</label>
                <input type="number" name="idade" required>
                <!--port-->
                <h2>Portugues</h2>
                <label>Prova: 1</label>
                <input type="number" name="portugues_prova1" min="0" max="10" step="0.1" required>
                <br><br>
                <label>Prova: 2</label>
                <input type="number" name="portugues_prova2" min="0" max="10" step="0.1" required>
                <br><br>
                <label>Prova: 3</label>
                <input type="number" name="portugues_prova3" min="0" max="10" step="0.1" required>
                <br><br>
                <!--mate-->
                <h2>Matematica</h2>
                <label>Prova: 1</label>
                <input type="number" name="matematica_prova1" min="0" max="10" step="0.1" required>
                <br><br>
                <label>Prova: 2</label>
                <input type="number" name="matematica_prova2" min="0" max="10" step="0.1" required>
                <br><br>
                <label>Prova: 3</label>
                <input type="number" name="matematica_prova3" min="0" max="10" step="0.1" required>
                <br><br>
                <!--historia-->
                <h2>Historia</h2>
                <label>Prova: 1</label>
                <input type="number" name="historia_prova1" min="0" max="10" step="0.1" required>
                <br><br>
                <label>Prova: 2</label>
                <input type="number" name="historia_prova2" min="0" max="10" step="0.1" required>
                <br><br>
                <label>Prova: 3</label>
                <input type="number" name="historia_prova3" min="0" max="10" step="0.1" required>
                <br><br>
                <button type="submit">ENVIAR FORMULARIO</button>
    </form>

    <h1>ALUNOS CADASTRADOS</h1>

    <?php foreach ($alunos as $aluno) { ?>

        <h2> <?= $aluno["nome"] ?> </h2>
        <p>Idade: <?= $aluno["idade"] ?> </p>
        <!--PORTUGUES-->
        <h2>PORTUGUES</h2>
        <p>Prova 1: <?= $aluno["notas"]["portugues"]["prova1"] ?> </p>
        <p>Prova 2: <?= $aluno["notas"]["portugues"]["prova2"] ?> </p>
        <p>Prova 3: <?= $aluno["notas"]["portugues"]["prova3"] ?> </p>
        <!--MATEMATICA-->
        <h2>MATEMATICA</h2>
        <p>Prova 1: <?= $aluno["notas"]["matematica"]["prova1"] ?> </p>
        <p>Prova 2: <?= $aluno["notas"]["matematica"]["prova2"] ?> </p>
        <p>Prova 3: <?= $aluno["notas"]["matematica"]["prova3"] ?> </p>
        <!--HISTORIA-->
        <h2>HISTORIA</h2>
        <p>Prova 1: <?= $aluno["notas"]["historia"]["prova1"] ?> </p>
        <p>Prova 2: <?= $aluno["notas"]["historia"]["prova2"] ?> </p>
        <p>Prova 3: <?= $aluno["notas"]["historia"]["prova3"] ?> </p>
    <?php } ?>



</body>

</html>