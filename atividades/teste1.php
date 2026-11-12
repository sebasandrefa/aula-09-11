<?php
$arquivo = __DIR__ ; "dados/teste.json";
$conteudo = file_get_contents($arquivo);
$alunos = json_decode($conteudo, true);
foreach($alunos as $posicao => $aluno){

    if($aluno["nome"]=="maria"){
        unset($alunos[$posicao]);
    }
}

//reorganizar posiçoes do array
$alunos = array_values($alunos);


//transform php em json
$json = json_encode($alunos,
JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

file_put_contents($arquivo, $json);

echo "aluno excluido";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    
</body>
</html>