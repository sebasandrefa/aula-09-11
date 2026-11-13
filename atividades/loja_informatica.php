<?php
require_once __DIR__ . "/conexao2.php";

$erro = "";
$sucesso = "";

if (isset($_POST["cadastrar"]) || isset($_POST["atualizar"])) {
    $nome = trim($_POST["nome"]);
    $categoria_id = (int) $_POST["categoria_id"];
    $preco = (float) $_POST["preco"];
    $quantidade = (int) $_POST["quantidade"];
    $estoque_minimo = (int) $_POST["estoque_minimo"];

    if ($nome == "") {
        $erro = "O nome do produto não pode ficar vazio.";
    } elseif ($categoria_id <= 0) {
        $erro = "Selecione uma categoria.";
    } elseif ($preco <= 0) {
        $erro = "O preço deve ser maior que zero.";
    } elseif ($quantidade < 0) {
        $erro = "A quantidade não pode ser negativa.";
    } elseif ($estoque_minimo < 0) {
        $erro = "O estoque mínimo não pode ser negativo.";
    } else {
        $nomeTratado = $pdo->quote($nome);

        if (isset($_POST["atualizar"])) {
            $id = (int) $_POST["id"];
            $sql = "UPDATE produtos SET nome = $nomeTratado, categoria_id = $categoria_id, preco = $preco, quantidade = $quantidade, estoque_minimo = $estoque_minimo WHERE id = $id";
            $pdo->exec($sql);
            $sucesso = "Produto atualizado com sucesso!";
        } else {
            $sql = "INSERT INTO produtos (nome, categoria_id, preco, quantidade, estoque_minimo) VALUES ($nomeTratado, $categoria_id, $preco, $quantidade, $estoque_minimo)";
            $pdo->exec($sql);
            $sucesso = "Produto cadastrado com sucesso!";
        }
    }
}

if (isset($_POST["excluir"])) {
    $id = (int) $_POST["id"];

    $sql = "SELECT COUNT(*) AS total FROM vendas WHERE produto_id = $id";
    $stmt = $pdo->query($sql);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado["total"] > 0) {
        $erro = "Este produto não pode ser removido porque já possui vendas registradas.";
    } else {
        $sql = "DELETE FROM produtos WHERE id = $id";
        $pdo->exec($sql);
        $sucesso = "Produto excluído com sucesso!";
    }
}

if (isset($_POST["repor"])) {
    $id = (int) $_POST["id"];
    $adicionar = (int) $_POST["adicionar"];

    if ($adicionar <= 0) {
        $erro = "Informe uma quantidade maior que zero para repor.";
    } else {
        $sql = "UPDATE produtos SET quantidade = quantidade + $adicionar WHERE id = $id";
        $pdo->exec($sql);
        $sucesso = "Estoque reposto com sucesso!";
    }
}

if (isset($_POST["vender"])) {
    $produto_id = (int) $_POST["produto_id"];
    $quantidadeVendida = (int) $_POST["quantidade"];

    $sql = "SELECT * FROM produtos WHERE id = $produto_id";
    $stmt = $pdo->query($sql);
    $produtoVenda = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produtoVenda) {
        $erro = "Selecione um produto.";
    } elseif ($quantidadeVendida <= 0) {
        $erro = "A quantidade da venda deve ser maior que zero.";
    } elseif ($quantidadeVendida > $produtoVenda["quantidade"]) {
        $erro = "Estoque insuficiente. Disponível: " . $produtoVenda["quantidade"];
    } else {
        $valor_total = $produtoVenda["preco"] * $quantidadeVendida;

        $sql = "INSERT INTO vendas (produto_id, quantidade, valor_total, data_venda) VALUES ($produto_id, $quantidadeVendida, $valor_total, NOW())";
        $pdo->exec($sql);

        $sql = "UPDATE produtos SET quantidade = quantidade - $quantidadeVendida WHERE id = $produto_id";
        $pdo->exec($sql);

        $sucesso = "Venda realizada! Valor total: R$ " . number_format($valor_total, 2, ",", ".");
    }
}

$produtoEditar = null;

if (isset($_GET["editar"]) && $sucesso == "") {
    $id = (int) $_GET["editar"];
    $sql = "SELECT * FROM produtos WHERE id = $id";
    $stmt = $pdo->query($sql);
    $produtoEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

$sql = "SELECT * FROM categorias ORDER BY nome ASC";
$stmt = $pdo->query($sql);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$busca = "";
$categoriaFiltro = 0;
$ordem = "";

if (isset($_GET["busca"])) {
    $busca = trim($_GET["busca"]);
}
if (isset($_GET["categoria"])) {
    $categoriaFiltro = (int) $_GET["categoria"];
}
if (isset($_GET["ordem"])) {
    $ordem = $_GET["ordem"];
}

$buscaTratada = $pdo->quote("%" . $busca . "%");

$sql = "SELECT produtos.*, categorias.nome AS categoria
FROM produtos
JOIN categorias ON categorias.id = produtos.categoria_id
WHERE produtos.nome LIKE $buscaTratada";

if ($categoriaFiltro > 0) {
    $sql = $sql . " AND produtos.categoria_id = $categoriaFiltro";
}

if (isset($_GET["baixo"])) {
    $sql = $sql . " AND produtos.quantidade > 0 AND produtos.quantidade <= produtos.estoque_minimo";
}

if ($ordem == "menor") {
    $sql = $sql . " ORDER BY produtos.preco ASC";
} elseif ($ordem == "maior") {
    $sql = $sql . " ORDER BY produtos.preco DESC";
} else {
    $sql = $sql . " ORDER BY produtos.id ASC";
}

$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM produtos ORDER BY nome ASC";
$stmt = $pdo->query($sql);
$produtosVenda = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) AS total_produtos, SUM(quantidade) AS total_unidades, SUM(preco * quantidade) AS valor_estoque FROM produtos";
$stmt = $pdo->query($sql);
$relatorioEstoque = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) AS total FROM produtos WHERE quantidade > 0 AND quantidade <= estoque_minimo";
$stmt = $pdo->query($sql);
$relatorioBaixo = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) AS total_vendas, SUM(valor_total) AS faturamento FROM vendas";
$stmt = $pdo->query($sql);
$relatorioVendas = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT vendas.*, produtos.nome
FROM vendas
JOIN produtos ON produtos.id = vendas.produto_id
ORDER BY vendas.id DESC";
$stmt = $pdo->query($sql);
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT produtos.nome, SUM(vendas.quantidade) AS total_vendido
FROM vendas
JOIN produtos ON produtos.id = vendas.produto_id
GROUP BY produtos.id, produtos.nome
ORDER BY total_vendido DESC
LIMIT 5";
$stmt = $pdo->query($sql);
$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Loja de Informática</title>

    <link rel="stylesheet" href="../css/loja_informatico.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <h2 class="logo">Loja de Informática</h2>

            <ul class="menu">
                <li><a href="../index.php">Portfólio</a></li>
                <li><a href="#resumo">Resumo</a></li>
                <li><a href="#cadastro">Cadastro</a></li>
                <li><a href="#produtos">Produtos</a></li>
                <li><a href="#venda">Venda</a></li>
                <li><a href="#historico">Histórico</a></li>
                <li><a href="#ranking">Ranking</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if ($erro != "") { ?>
            <p class="mensagem erro"><?= $erro ?></p>
        <?php } ?>

        <?php if ($sucesso != "") { ?>
            <p class="mensagem sucesso"><?= $sucesso ?></p>
        <?php } ?>

        <section id="resumo" class="secao">
            <h2 class="titulo-secao">Resumo da Loja</h2>

            <table>
                <tr>
                    <th>Informação</th>
                    <th>Valor</th>
                </tr>
                <tr>
                    <td>Produtos diferentes cadastrados</td>
                    <td> <?= $relatorioEstoque["total_produtos"] ?> </td>
                </tr>
                <tr>
                    <td>Unidades disponíveis em estoque</td>
                    <td> <?= (int) $relatorioEstoque["total_unidades"] ?> </td>
                </tr>
                <tr>
                    <td>Valor total do estoque</td>
                    <td>R$ <?= number_format((float) $relatorioEstoque["valor_estoque"], 2, ",", ".") ?> </td>
                </tr>
                <tr>
                    <td>Produtos com estoque baixo</td>
                    <td> <?= $relatorioBaixo["total"] ?> </td>
                </tr>
                <tr>
                    <td>Vendas registradas</td>
                    <td> <?= $relatorioVendas["total_vendas"] ?> </td>
                </tr>
                <tr>
                    <td>Valor total faturado</td>
                    <td>R$ <?= number_format((float) $relatorioVendas["faturamento"], 2, ",", ".") ?> </td>
                </tr>
            </table>
        </section>

        <section id="cadastro" class="secao">
            <h2 class="titulo-secao">
                <?php
                if ($produtoEditar) {
                    echo "EDITAR PRODUTO";
                } else {
                    echo "CADASTRAR PRODUTO";
                }
                ?>
            </h2>

            <form method="POST" class="formulario">
                <?php if ($produtoEditar) { ?>
                    <input type="hidden" name="id" value="<?= $produtoEditar["id"] ?>">
                <?php } ?>

                <label>Nome do Produto:</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($produtoEditar["nome"] ?? "") ?>">

                <label>Categoria:</label>
                <select name="categoria_id">
                    <option value="0">Selecione...</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?= $categoria["id"] ?>" <?php if ($produtoEditar && $produtoEditar["categoria_id"] == $categoria["id"]) { echo "selected"; } ?>>
                            <?= htmlspecialchars($categoria["nome"]) ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Preço:</label>
                <input type="number" name="preco" step="0.01" value="<?= $produtoEditar["preco"] ?? "" ?>">

                <label>Quantidade:</label>
                <input type="number" name="quantidade" value="<?= $produtoEditar["quantidade"] ?? "" ?>">

                <label>Estoque mínimo:</label>
                <input type="number" name="estoque_minimo" value="<?= $produtoEditar["estoque_minimo"] ?? "" ?>">

                <?php if ($produtoEditar) { ?>
                    <button type="submit" name="atualizar" class="botao">Atualizar Produto</button>
                <?php } else { ?>
                    <button type="submit" name="cadastrar" class="botao">Cadastrar Produto</button>
                <?php } ?>
            </form>
        </section>

        <section id="produtos" class="secao">
            <h2 class="titulo-secao">Produtos Cadastrados</h2>

            <form method="GET" action="loja_informatica.php" class="filtros">
                <label>Nome:</label>
                <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>">

                <label>Categoria:</label>
                <select name="categoria">
                    <option value="0">Todas</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?= $categoria["id"] ?>"><?= htmlspecialchars($categoria["nome"]) ?></option>
                    <?php } ?>
                </select>

                <label>Ordenar:</label>
                <select name="ordem">
                    <option value="">Padrão</option>
                    <option value="menor">Menor preço</option>
                    <option value="maior">Maior preço</option>
                </select>

                <label>
                    <input type="checkbox" name="baixo"> Somente estoque baixo
                </label>

                <button type="submit" class="botao">Filtrar</button>
            </form>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Estoque mínimo</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($produtos as $produto) { ?>
                    <?php
                    if ($produto["quantidade"] == 0) {
                        $situacao = "ESGOTADO";
                    } elseif ($produto["quantidade"] <= $produto["estoque_minimo"]) {
                        $situacao = "ESTOQUE BAIXO";
                    } else {
                        $situacao = "DISPONÍVEL";
                    }
                    ?>
                    <tr>
                        <td> <?= $produto["id"] ?> </td>
                        <td> <?= htmlspecialchars($produto["nome"]) ?> </td>
                        <td> <?= htmlspecialchars($produto["categoria"]) ?> </td>
                        <td>R$ <?= number_format($produto["preco"], 2, ",", ".") ?> </td>
                        <td> <?= $produto["quantidade"] ?> </td>
                        <td> <?= $produto["estoque_minimo"] ?> </td>
                        <td> <?= $situacao ?> </td>
                        <td>
                            <a href="loja_informatica.php?editar=<?= $produto["id"] ?>#cadastro">Editar</a>

                            <form method="POST" action="loja_informatica.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $produto["id"] ?>">
                                <button type="submit" name="excluir" onclick="return confirm('Deseja excluir este produto?')">Excluir</button>
                            </form>

                            <form method="POST" action="loja_informatica.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $produto["id"] ?>">
                                <input type="number" name="adicionar" placeholder="qtd" style="width:60px;">
                                <button type="submit" name="repor">Repor</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </section>

        <section id="venda" class="secao">
            <h2 class="titulo-secao">Registrar Venda</h2>

            <form method="POST" action="loja_informatica.php" class="formulario">
                <label>Produto:</label>
                <select name="produto_id">
                    <option value="0">Selecione...</option>
                    <?php foreach ($produtosVenda as $produto) { ?>
                        <option value="<?= $produto["id"] ?>">
                            <?= htmlspecialchars($produto["nome"]) ?>
                            - R$ <?= number_format($produto["preco"], 2, ",", ".") ?>
                            (estoque: <?= $produto["quantidade"] ?>)
                        </option>
                    <?php } ?>
                </select>

                <label>Quantidade:</label>
                <input type="number" name="quantidade">

                <button type="submit" name="vender" class="botao">Registrar Venda</button>
            </form>
        </section>

        <section id="historico" class="secao">
            <h2 class="titulo-secao">Histórico de Vendas</h2>

            <table>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor total</th>
                    <th>Data da venda</th>
                </tr>
                <?php foreach ($vendas as $venda) { ?>
                    <tr>
                        <td> <?= htmlspecialchars($venda["nome"]) ?> </td>
                        <td> <?= $venda["quantidade"] ?> </td>
                        <td>R$ <?= number_format($venda["valor_total"], 2, ",", ".") ?> </td>
                        <td> <?= $venda["data_venda"] ?> </td>
                    </tr>
                <?php } ?>
            </table>
        </section>

        <section id="ranking" class="secao">
            <h2 class="titulo-secao">Os 5 Produtos Mais Vendidos</h2>

            <table>
                <tr>
                    <th>Produto</th>
                    <th>Unidades vendidas</th>
                </tr>
                <?php foreach ($ranking as $item) { ?>
                    <tr>
                        <td> <?= htmlspecialchars($item["nome"]) ?> </td>
                        <td> <?= $item["total_vendido"] ?> </td>
                    </tr>
                <?php } ?>
            </table>
        </section>
    </main>

    <footer>
        <p>
            Desenvolvido por Sebastián Andrade . 2026
        </p>
    </footer>

</body>

</html>