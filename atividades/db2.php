<?php
require_once __DIR__ . "/conexao2.php";

//1-criar tabela categorias
$sql = "CREATE TABLE IF NOT EXISTS categorias (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL)";

$pdo->exec($sql);

//2-criar tabela produtos
$sql = "CREATE TABLE IF NOT EXISTS produtos (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(150) NOT NULL,
categoria_id INT,
preco DECIMAL(10,2) NOT NULL,
quantidade INT NOT NULL,
estoque_minimo INT NOT NULL,
FOREIGN KEY (categoria_id) REFERENCES categorias(id))";

$pdo->exec($sql);

//3-criar tabela vendas
$sql = "CREATE TABLE IF NOT EXISTS vendas (
id INT AUTO_INCREMENT PRIMARY KEY,
produto_id INT,
quantidade INT NOT NULL,
valor_total DECIMAL(10,2) NOT NULL,
data_venda DATETIME NOT NULL,
FOREIGN KEY (produto_id) REFERENCES produtos(id))";

$pdo->exec($sql);

//4-cadastrar os registros iniciais (so se as tabelas estiverem vazias)
$sql = "SELECT COUNT(*) FROM categorias";
$total = $pdo->query($sql)->fetchColumn();

if ($total == 0) {
    $sql = "INSERT INTO categorias (nome) VALUES
    ('Perifericos'),
    ('Hardware'),
    ('Armazenamento'),
    ('Monitores'),
    ('Redes')";

    $pdo->exec($sql);

    $sql = "INSERT INTO produtos (nome, categoria_id, preco, quantidade, estoque_minimo) VALUES
    ('Teclado Mecanico', 1, 150.00, 20, 5),
    ('Mouse Gamer', 1, 89.90, 15, 5),
    ('Headset USB', 1, 199.90, 3, 4),
    ('Memoria RAM 8GB DDR4', 2, 179.00, 12, 4),
    ('Processador Ryzen 5', 2, 899.00, 2, 3),
    ('Placa de Video GTX 1650', 2, 1299.00, 0, 2),
    ('SSD 480GB', 3, 249.90, 10, 3),
    ('HD Externo 1TB', 3, 349.00, 6, 2),
    ('Monitor 24 Polegadas', 4, 799.00, 5, 2),
    ('Monitor 27 Polegadas', 4, 1199.00, 2, 2),
    ('Roteador Wi-Fi', 5, 159.90, 8, 3),
    ('Cabo de Rede 5m', 5, 19.90, 40, 10)";

    $pdo->exec($sql);
}

//5-listar o que foi criado
$sql = "SELECT * FROM categorias ORDER BY id ASC";
$stmt = $pdo->query($sql);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT produtos.*, categorias.nome AS categoria
FROM produtos
JOIN categorias ON categorias.id = produtos.categoria_id
ORDER BY produtos.id ASC";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tabelas da Loja</title>

    <link rel="stylesheet" href="../css/loja_informatico.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <h2 class="logo">Tabelas da Loja</h2>

            <ul class="menu">
                <li><a href="loja_informatica.php">Abrir o sistema</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="categorias" class="secao">
            <h2 class="titulo-secao">Categorias</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                </tr>
                <?php foreach ($categorias as $categoria) { ?>
                    <tr>
                        <td> <?= $categoria["id"] ?> </td>
                        <td> <?= htmlspecialchars($categoria["nome"]) ?> </td>
                    </tr>
                <?php } ?>
            </table>
        </section>

        <section id="produtos" class="secao">
            <h2 class="titulo-secao">Produtos</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Estoque mínimo</th>
                </tr>
                <?php foreach ($produtos as $produto) { ?>
                    <tr>
                        <td> <?= $produto["id"] ?> </td>
                        <td> <?= htmlspecialchars($produto["nome"]) ?> </td>
                        <td> <?= htmlspecialchars($produto["categoria"]) ?> </td>
                        <td>R$ <?= number_format($produto["preco"], 2, ",", ".") ?> </td>
                        <td> <?= $produto["quantidade"] ?> </td>
                        <td> <?= $produto["estoque_minimo"] ?> </td>
                    </tr>
                <?php } ?>
            </table>
        </section>
    </main>
</body>
</html>