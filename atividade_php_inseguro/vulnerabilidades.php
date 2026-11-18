<?php
// Objetivo: localizar, explicar e corrigir vulnerabilidades.
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();

$host = '127.0.0.1';
$banco = 'sebastian755_db1';
$usuario = 'sebastian755';
$senha = '755!@#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro ao conectar com o banco de dados.');
}

$mensagem = $_GET['msg'] ?? '';
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

if ($acao === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['senha'] ?? '';

    if ($email === '' || $password === '') {
        $mensagem = 'Preencha o e-mail e a senha.';
    } else {

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $encontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($encontrado && password_verify($password, $encontrado['senha'])) {

            session_regenerate_id(true); 
            $_SESSION['usuario'] = $encontrado['nome'];
            $_SESSION['perfil'] = $encontrado['perfil'];
            $mensagem = 'Bem-vindo, ' . $encontrado['nome']; 
        } else {
            $mensagem = 'E-mail ou senha inválidos.';
        }
    }
}

if ($acao === 'sair') {
    session_destroy();
    header('Location: index.php?msg=Você saiu');
    exit;
}

if ($acao === 'cadastrar') {

     if (!isset($_SESSION['usuario'])) {
        die('Acesso negado. Faça login.');
    }

    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $estoque = $_POST['estoque'] ?? '';
    $categoria = $_POST['categoria'] ?? '';

    $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $estoque, $categoria]);
    $mensagem = "Produto $nome cadastrado!";
}

if ($acao === 'atualizar') {
    if (!isset($_SESSION['usuario'])) {
        die('Acesso negado. Faça login.');
    }

    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $estoque = $_POST['estoque'] ?? '';
    $categoria = $_POST['categoria'] ?? '';

    $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, categoria=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $estoque, $categoria, $id]);
    $mensagem = 'Produto atualizado.';
}

if ($acao === 'excluir' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (($_SESSION['perfil'] ?? '') !== 'admin') {
        die('Acesso negado. Apenas o administrador pode excluir.');
    }

    $id = $_POST['id'] ?? '';
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id=?");
    $stmt->execute([$id]);
    $mensagem = 'Produto excluído.';
}

$busca = $_GET['busca'] ?? '';
$categoriaFiltro = $_GET['categoria'] ?? '';
$ordem = $_GET['ordem'] ?? 'id';

$sqlLista = "SELECT * FROM produtos WHERE (nome LIKE ? OR descricao LIKE ?)";
$parametros = ["%$busca%", "%$busca%"];

if ($categoriaFiltro !== '') {
    $sqlLista .= " AND categoria = ?";
    $parametros[] = $categoriaFiltro;
}

$sqlLista .= " ORDER BY $ordem";
$stmt = $pdo->prepare($sqlLista);
$stmt->execute($parametros);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$editar = null;

if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id=?');
    $stmt->execute([$_GET['editar']]);
    $editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

$total = $pdo->query('SELECT COUNT(*) FROM produtos')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Fácil — Laboratório</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Estoque Fácil</h1>
    <p>Sistema de estoque da loja fictícia</p>
</header>

<main>
    <div class="aviso">LABORATÓRIO INSEGURO — SOMENTE LOCALHOST</div>

    <?php if ($mensagem !== ''): ?>
        <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <section class="painel">
        <h2>Acesso ao sistema</h2>

        <?php if (isset($_SESSION['usuario'])): ?>
            <p>Usuário: <?= htmlspecialchars($_SESSION['usuario']) ?> | Perfil: <?= htmlspecialchars($_SESSION['perfil']) ?></p>
            <a href="?acao=sair">Sair</a>
        <?php else: ?>
            <form method="post">
                <input type="hidden" name="acao" value="login">
                <label>E-mail <input name="email" type="email" required placeholder="email@exemplo.local"></label>
                <label>Senha <input name="senha" type="password" required placeholder="Senha"></label>
                <button>Entrar</button>
            </form>
        <?php endif; ?>
    </section>

    <section class="painel">
        <h2><?= $editar ? 'Editar produto' : 'Cadastrar produto' ?></h2>

        <form method="post" class="grade">
            <input type="hidden" name="acao" value="<?= $editar ? 'atualizar' : 'cadastrar' ?>">

            <?php if ($editar): ?>
                <input type="hidden" name="id" value="<?= $editar['id'] ?>">
            <?php endif; ?>

            <label>Nome <input name="nome" required maxlength="150" value="<?= htmlspecialchars($editar['nome'] ?? '') ?>"></label>
            <label>Categoria <input name="categoria" required maxlength="80" value="<?= htmlspecialchars($editar['categoria'] ?? '') ?>"></label>
            <label>Preço (R$) <input name="preco" type="number" required min="0.01" step="0.01" value="<?= htmlspecialchars($editar['preco'] ?? '') ?>"></label>
            <label>Estoque <input name="estoque" type="number" required min="0" step="1" value="<?= htmlspecialchars($editar['estoque'] ?? '') ?>"></label>
            <label class="largura">Descrição <textarea name="descricao"><?= htmlspecialchars($editar['descricao'] ?? '') ?></textarea></label>

            <div>
                <button><?= $editar ? 'Salvar alterações' : 'Cadastrar' ?></button>
                <a href="index.php">Limpar</a>
            </div>
        </form>
    </section>

    <section class="painel">
        <h2>Produtos cadastrados (<?= $total ?>)</h2>

        <form method="get" class="filtros">
            <input name="busca" placeholder="Buscar nome ou descrição" value="<?= htmlspecialchars($busca) ?>">
            <input name="categoria" placeholder="Filtrar categoria" value="<?= htmlspecialchars($categoriaFiltro) ?>">
            <select name="ordem">
            <option value="id">Código</option>
            <option value="nome">Nome</option>
            <option value="preco">Preço</option>
            <option value="<?= htmlspecialchars($ordem) ?>" selected>Ordenação atual</option>
            </select>
            <button>Pesquisar</button>
        </form>


        <div class="tabela">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['id']) ?></td>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= htmlspecialchars($produto['descricao'] ?? '') ?></td>
                <td><?= htmlspecialchars($produto['categoria']) ?></td>
                <td>R$ <?= htmlspecialchars($produto['preco']) ?></td>
                <td><?= htmlspecialchars($produto['estoque']) ?></td>
            <td>
                <a href="?editar=<?= htmlspecialchars($produto['id']) ?>">Editar</a>
                <form method="post" class="form-excluir">
                    <input type="hidden" name="acao" value="excluir">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
                <button class="botao-excluir">Excluir</button>
                </form>
            </td>
            </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </section>

    <section class="painel">
        <h2>Observações da loja</h2>
        <p>Esta página foi criada para a turma identificar problemas reais de desenvolvimento web.</p>
        <p>Mensagem de campanha: <?= $_GET['campanha'] ?? 'Nenhuma campanha ativa' ?></p>
    </section>
</main>

<footer>Estoque Fácil • Ambiente de laboratório</footer>

</body>
</html>
