<?php
// Objetivo: localizar, explicar e corrigir vulnerabilidades.
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$host = '127.0.0.1';
$banco = 'xxxxxxx';
$usuario = 'xxxxxxx';
$senha = 'xxxxxxx';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falha no banco: ' . $e->getMessage());
}
$mensagem = $_GET['msg'] ?? '';
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
if ($acao === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['senha'] ?? '';
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$password'";
    $encontrado = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    if ($encontrado) {
        $_SESSION['usuario'] = $encontrado['nome'];
        $_SESSION['perfil'] = $encontrado['perfil'];
        $mensagem = 'Bem-vindo, ' . $encontrado['nome'];
    } else { $mensagem = 'Login inválido para ' . $email; }
}
if ($acao === 'sair') { session_destroy(); header('Location: index.php?msg=Você saiu'); exit; }
if ($acao === 'cadastrar') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $estoque = $_POST['estoque'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria) VALUES ('$nome', '$descricao', '$preco', '$estoque', '$categoria')";
    $pdo->exec($sql);
    $mensagem = "Produto $nome cadastrado!";
}
if ($acao === 'atualizar') {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $estoque = $_POST['estoque'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $sql = "UPDATE produtos SET nome='$nome', descricao='$descricao', preco='$preco', estoque='$estoque', categoria='$categoria' WHERE id=$id";
    $pdo->exec($sql);
    $mensagem = 'Produto atualizado.';
}
if ($acao === 'excluir') {
    $id = $_GET['id'] ?? '';
    $pdo->exec("DELETE FROM produtos WHERE id=$id");
    $mensagem = 'Produto excluído.';
}
$busca = $_GET['busca'] ?? '';
$categoriaFiltro = $_GET['categoria'] ?? '';
$ordem = $_GET['ordem'] ?? 'id';
$sqlLista = "SELECT * FROM produtos WHERE (nome LIKE '%$busca%' OR descricao LIKE '%$busca%')";
if ($categoriaFiltro !== '') { $sqlLista .= " AND categoria = '$categoriaFiltro'"; }
$sqlLista .= " ORDER BY $ordem";
$produtos = $pdo->query($sqlLista)->fetchAll(PDO::FETCH_ASSOC);
$editar = null;
if (isset($_GET['editar'])) {
    $editar = $pdo->query('SELECT * FROM produtos WHERE id=' . $_GET['editar'])->fetch(PDO::FETCH_ASSOC);
}
$total = $pdo->query('SELECT COUNT(*) FROM produtos')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Estoque Fácil — Laboratório</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Estoque Fácil</h1><p>Sistema de estoque da loja fictícia</p></header>
<main>
<div class="aviso">LABORATÓRIO INSEGURO — SOMENTE LOCALHOST</div>
<?php if ($mensagem !== ''): ?><div class="mensagem"><?= $mensagem ?></div><?php endif; ?>
<section class="painel">
<h2>Acesso ao sistema</h2>
<?php if (isset($_SESSION['usuario'])): ?>
<p>Usuário: <?= $_SESSION['usuario'] ?> | Perfil: <?= $_SESSION['perfil'] ?></p>
<a href="?acao=sair">Sair</a>
<?php else: ?>
<form method="post"><input type="hidden" name="acao" value="login">
<label>E-mail <input name="email" placeholder="email@exemplo.local"></label>
<label>Senha <input name="senha" type="text" placeholder="Senha"></label>
<button>Entrar</button></form>
<?php endif; ?>
</section>
<section class="painel"><h2><?= $editar ? 'Editar produto' : 'Cadastrar produto' ?></h2>
<form method="post" class="grade">
<input type="hidden" name="acao" value="<?= $editar ? 'atualizar' : 'cadastrar' ?>">
<?php if ($editar): ?><input type="hidden" name="id" value="<?= $editar['id'] ?>"><?php endif; ?>
<label>Nome <input name="nome" value="<?= $editar['nome'] ?? '' ?>"></label>
<label>Categoria <input name="categoria" value="<?= $editar['categoria'] ?? '' ?>"></label>
<label>Preço (R$) <input name="preco" value="<?= $editar['preco'] ?? '' ?>"></label>
<label>Estoque <input name="estoque" value="<?= $editar['estoque'] ?? '' ?>"></label>
<label class="largura">Descrição <textarea name="descricao"><?= $editar['descricao'] ?? '' ?></textarea></label>
<div><button><?= $editar ? 'Salvar alterações' : 'Cadastrar' ?></button> <a href="index.php">Limpar</a></div>
</form></section>
<section class="painel"><h2>Produtos cadastrados (<?= $total ?>)</h2>
<form method="get" class="filtros">
<input name="busca" placeholder="Buscar nome ou descrição" value="<?= $busca ?>">
<input name="categoria" placeholder="Filtrar categoria" value="<?= $categoriaFiltro ?>">
<select name="ordem"><option value="id">Código</option><option value="nome">Nome</option><option value="preco">Preço</option><option value="<?= $ordem ?>" selected>Ordenação atual</option></select>
<button>Pesquisar</button></form>
<div class="tabela"><table><thead><tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr></thead><tbody>
<?php foreach ($produtos as $produto): ?>
<tr><td><?= $produto['id'] ?></td><td><?= $produto['nome'] ?></td><td><?= $produto['descricao'] ?></td><td><?= $produto['categoria'] ?></td><td>R$ <?= $produto['preco'] ?></td><td><?= $produto['estoque'] ?></td>
<td><a href="?editar=<?= $produto['id'] ?>">Editar</a> <a href="?acao=excluir&id=<?= $produto['id'] ?>">Excluir</a></td></tr>
<?php endforeach; ?>
</tbody></table></div>
</section>
<section class="painel"><h2>Observações da loja</h2><p>Esta página foi criada para a turma identificar problemas reais de desenvolvimento web.</p>
<p>Mensagem de campanha: <?= $_GET['campanha'] ?? 'Nenhuma campanha ativa' ?></p></section>
</main><footer>Estoque Fácil • Ambiente de laboratório</footer>
</body></html>
