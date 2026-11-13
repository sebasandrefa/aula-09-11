<?php
//db1.php
require_once "../conexao.php";

//1-criar tabela
$sql = "CREATE TABLE IF NOT EXISTS produtos (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
preco DECIMAL(10,2) NOT NULL,
quantidade INT NOT NULL)";

$pdo->exec($sql);

//2-cadastrar produto
if (isset($_POST["cadastrar"])) {
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $quantidade = $_POST["quantidade"];

    $sql = "INSERT INTO produtos (nome, preco, quantidade) VALUES ('$nome', $preco, $quantidade)";


    $stmt = $pdo->prepare($sql);

    $stmt->execute();

}

//3-atualizar produto
if (isset($_POST["atualizar"])) {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $quantidade = $_POST["quantidade"];
    $sql = "UPDATE produtos SET nome = '$nome', preco = $preco, quantidade = $quantidade WHERE id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

//4-excluir
if (isset($_POST["excluir"])) {
    $id = $_POST["id"];
    $sql = "DELETE FROM produtos WHERE id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

//5-buscarProdutoParaEdiçao
$produtoEditar = null;

if (isset($_GET["editar"])) {
    $id = $_GET["editar"];
    $sql = "SELECT * FROM produtos WHERE id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtoEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

//6-listar todos os produtos

$sql = "SELECT * FROM produtos ORDER BY id ASC";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/db1.css">
</head>

<body>
    <h1>Sistema de Cadastro de produtos</h1>
    <h2>
        <?php
        if ($produtoEditar) {
            echo "EDITAR PRODUTO";
        } else {
            echo "CADASTRAR PRODUTOS";
        }
        ?>
    </h2>

    <form method="POST">
        <?php if ($produtoEditar) { ?>
            <input type="hidden" name="id" value="<?= $produtoEditar['id'] ?>">
        <?php } ?>
        <label>Nome do Produto:</label>
        <input type="text" name="nome" value="<?= $produtoEditar['nome'] ?? '' ?>">
        <br><br>
        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" min="0" required value="<?php $produtoEditar['preco'] ?? '' ?>">
        <label>Quantidade:</label>
        <input type="number" name="quantidade" min="0" required value="<?= $produtoEditar['quantidade'] ?? '' ?>">
        <br><br>
        <?php if ($produtoEditar) { ?>
            <button type="submit" name="atualizar">Atualizar Produto</button>
        <?php } else { ?>
            <button type="submit" name="cadastrar">Cadastrar Produto</button>
        <?php } ?>
    </form>
    <hr>
    <h2>Produtos Cadastrados</h2>
    <table>
        <!-- tr table row crea una linea dentro de la tabla -->
        <tr>
            <!-- th table header crea una celula de cabeçalho en la tabla -->
            <th>ID</th>
            <th>nome</th>
            <th>preco</th>
            <th>quantidade</th>
            <th>açoes</th>
        </tr>
        <?php foreach ($produtos as $produto) { ?>
            <tr>
                <!-- td table data crea una celula de datos en la tabla -->
                <td> <?= $produto["id"] ?> </td>
                <td> <?= htmlspecialchars($produto["nome"]) ?> </td>
                <td>R$ <?= number_format($produto["preco"], 2, ",", ".") ?> </td>
                <td> <?= $produto["quantidade"] ?> </td>
                <td>
                    <!-- EDITAR -->
                    <a href="db1.php?editar=<?= $produto['id'] ?>">Editar</a>
                    <!-- EXCLUIR -->
                    <form method="POST" action="db1.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                        <button type="submit" name="excluir" onclick="return confirm ('Desjea excluir este produto?')">Excluir</button>
                    </form>
                </td>


            </tr>
        <?php } ?>
    </table>
</body>

</html>