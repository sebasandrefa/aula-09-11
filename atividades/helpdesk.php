<?php
require_once "helpdesk-func.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $setor = $_POST["setor"];
    $equipamento = $_POST["equipamento"];
    $descricao = $_POST["descricao"];
    $prioridade = $_POST["prioridade"];

    $novoChamado = [
        "nome" => $nome,
        "setor" => $setor,
        "equipamento" => $equipamento,
        "descricao" => $descricao,
        "prioridade" => $prioridade
    ];

    //ler abrir o arquivo json //json to array php
    $conteudoJson = file_get_contents(__DIR__ . "../dados/chamados.json");
    $chamados = json_decode($conteudoJson, true);

    //adicionar chamado
    $chamados[] = $novoChamado;

    //array php to json
    $jsonAtualizado = json_encode(
        $chamados,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    //salvar json
    file_put_contents(__DIR__ . "../dados/chamados.json", $jsonAtualizado);
    $conteudoJson = file_get_contents(__DIR__ . "../dados/chamados.json");
    $chamados = json_decode($conteudoJson, true);
}



$conteudoJson = file_get_contents(__DIR__ . "../dados/chamados.json");
$chamados = json_decode($conteudoJson, true);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>helpdesk</title>
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
    <h1>BEM VINDO AO HELPDESK: <?= $nomeEmpresa ?> </h1>
    <main>
        <!--CREATE-->
        <section class="formulario">
            <h2>FORMULARIO</h2>
            <form method="POST">
                <label>NOME DO FUNCIONARIO</label>
                <input type="text" name="nome" required>
                <label>SETOR DA EMPRESA</label>
                <input type="text" name="setor" required>
                <label>EQUIPAMENTO AFETADO</label>
                <input type="text" name="equipamento" required>
                <label>DESCRIÇÃO:</label>
                <input type="text" name="descricao" required>
                <label>PRIORIDADE</label>
                <input type="text" name="prioridade" required>
                <button type="submit">ENVIAR</button>
            </form>
        </section>
        <!--READ-->
        <section class="chamados">
            <h2>CHAMADOS</h2>
            <?php foreach ($chamados as $chamado) { ?>
                <p> NOME DO FUNCIONARIO: <?= $chamado["nome"] ?> </p>
                <p> SETOR DA EMPRESA: <?= $chamado["setor"] ?> </p>
                <p> EQUIPAMENTO: <?= $chamado["equipamento"] ?> </p>
                <p> PRIORIDADE: <?= $chamado["prioridade"] ?> </p>
                <button type="submit"
                    <?php foreach ($chamados as $posicao => $chamado) {
                        unset($chamados[$posicao]);
                    } ?>> ELIMINAR CHAMADO
                </button>
            <?php } ?>

        </section>
        <!--UPDATE-->
        <section class="atualizar">
            
        </section>
        <!--END-->
    </main>

    <footer>
        <p>
            DESENVOLVIDO POR <a href="https://jose755.devlook.xyz">JOSE OROPESA</a>
        </p>
        <p>
            HTML + CSS + PHP + JSON
        </p>
    </footer>

</body>

</html>