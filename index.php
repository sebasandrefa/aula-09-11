<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Meu Portfolio</title>

    <link rel="stylesheet" href="css/05-portfolio.css">

</head>
<body class="pagina-inicio">
    <!-- =====================
         MENU DE NAVEGAÇÃO
    ====================== -->
    <header>
        <nav class="navbar">
            <h2 class="logo">Meu Portfólio</h2>

            <ul class="menu">
                <li><a href="#inicio">Início</a></li>
                <li><a href="#sobre">Sobre</a></li>
                <li><a href="#habilidades">Habilidades</a></li>
                <li><a href="#projetos">Projetos</a></li>
                <li><a href="#contato">Contato</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="inicio" class="inicio">
            
        <div class="inicio-conteudo">

            <p class="saudacao">Olá! Eu sou </p>

            <h1>Sebastián Andrade</h1>

            <h2>Desenvolvedor em formação</h2>

            <p>
                Sou desenvolvedor de sistemas com foco em criar 
                soluções práticas, eficientes e com boa experiência 
                de uso, foco em criação de sites.
            </p>
            <a href="#projetos" class="botao">
                Ver meus projetos
            </a>
        </div>
    </section>
    <section id="sobre" class="secao">
        <h2 class="titulo-secao"> Sobre mim </h2>
        <div class="sobre-conteudo">
            <h3>Quem sou eu?</h3>
            <p>
                Meu nome é Sebastián Andrade e sou aluno
                de Analise em desenvolvimento de Sistemas.
            </p>

            <p>
                Atualmente estou ainda tendo aulas e não conclui o curso.
                Este portfólio reúne alguns dos projetos que desenvolvi durante
                o curso.
            </p>

            <p>

                Meu objetivo é continuar aprendendo e me tornar um desenvolvedor de sistemas
                completo. fazendo sites, programando e dando soluções aos problemas do dia a dia.
            </p>
        </div>
    </section>

    <section>
        <section id="habilidades" class="secao secao-destaque">
            <h2 class="titulo-secao">Habilidades</h2>
            <p class="subtitulo-secao">
                Algumas tecnologias que estou estudando:
            </p>
            <div class="lista-habilidades">
                <div class="habilidade">
                    HTML
                </div>
                <div class="habilidade">
                    CSS
                </div>
                <div class="habilidade">
                    PHP
                </div>
                <div class="habilidade">
                    PHYTON
                </div>
                <div class="habilidade">
                    NODE.JS
                </div>
                <div class="habilidade">
                    REACT
                </div>
            </div>
        </section>
        <section id="projetos" class="secao">
            <h2 class="titulo-secao">Meus Projetos</h2>
            <p class="subtitulo-secao">
                Projetos e atividades desenvolvidos durante o curso:
            </p>
            <div class="projetos-container">
                <article class="projeto-card">
                    <div class="projeto-numero">01</div>
                    <h3>Cadastro de notas com JSON</h3>
                    <p>Formulário para cadastrar alunos e organizar notas de Português, Matemática e História em JSON.</p>
                    <div class="tecnologias"><span>PHP</span><span>JSON</span><span>HTML</span><span>CSS</span></div>
                    <a href="atividades/dados-json.php" class="link-projeto">Ver projeto →</a>
                </article>
                <article class="projeto-card">
                    <div class="projeto-numero">02</div>
                    <h3>Funções e cálculo de média</h3>
                    <p>Exercício de funções PHP com saudação, operações matemáticas e cálculo de situação escolar.</p>
                    <div class="tecnologias"><span>PHP</span><span>Funções</span><span>HTML</span><span>CSS</span></div>
                    <a href="atividades/funcoes2.php" class="link-projeto">Ver projeto →</a>
                </article>
                <article class="projeto-card">
                    <div class="projeto-numero">03</div>
                    <h3>Helpdesk de chamados</h3>
                    <p>Interface para registrar chamados de suporte com setor, equipamento, descrição e prioridade.</p>
                    <div class="tecnologias"><span>PHP</span><span>JSON</span><span>HTML</span><span>CSS</span></div>
                    <a href="atividades/helpdesk.php" class="link-projeto">Ver projeto →</a>
                </article>
                <article class="projeto-card">
                    <div class="projeto-numero">04</div>
                    <h3>Funções PHP</h3>
                    <p>Biblioteca de funções para saudações, soma, média e verificação de aprovação.</p>
                    <div class="tecnologias"><span>PHP</span><span>Lógica</span></div>
                    <span class="link-projeto projeto-indisponivel">Arquivo de apoio</span>
                </article>
                <article class="projeto-card">
                    <div class="projeto-numero">05</div>
                    <h3>Funções do Helpdesk</h3>
                    <p>Arquivo de apoio separado para organizar a lógica de gerenciamento de chamados.</p>
                    <div class="tecnologias"><span>PHP</span><span>JSON</span></div>
                    <span class="link-projeto projeto-indisponivel">Arquivo de apoio</span>
                </article>
                <article class="projeto-card">
                    <div class="projeto-numero">06</div>
                    <h3>Atualização de dados JSON</h3>
                    <p>Exercício de leitura, alteração e gravação de dados em um arquivo JSON.</p>
                    <div class="tecnologias"><span>PHP</span><span>JSON</span></div>
                    <span class="link-projeto projeto-indisponivel">Script de demonstração</span>
                </article>
                <article class="projeto-card">
                    <div class="projeto-numero">07</div>
                    <h3>Remoção de dados JSON</h3>
                    <p>Exercício de filtragem de registros e reorganização de uma lista JSON.</p>
                    <div class="tecnologias"><span>PHP</span><span>JSON</span></div>
                    <span class="link-projeto projeto-indisponivel">Script de demonstração</span>
                </article>
                <article class="projeto-card">
                    <div class="projeto-numero">08</div>
                    <h3>Loja de Informática</h3>
                    <p>Sistema de controle de estoque e vendas com cadastro de produtos, registro de vendas e relatórios.</p>
                    <div class="tecnologias"><span>PHP</span><span>MySQL</span><span>PDO</span><span>HTML</span><span>CSS</span></div>
                    <a href="atividades/loja_informatica.php" class="link-projeto">Ver projeto →</a>
                </article>
            </div>
        </section>
        <section id="contato" class="secao secao-destaque">
            <h2 class="titulo-secao">Contato</h2>
            <p class="subtitulo-secao">
                Quer entrar em contato comigo?
            </p>
            <div class="contato-container">
                <div class="contato-item">
                    <h3>Email:</h3>
                    <p>sebasandrefa@gmail.com</p>
                </div>
                <div class="contato-item">
                    <h3>Github:</h3>
                    <p>github.com/sebasandrefa</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>
            Desenvolvido por <a href="https://sebastian755.devlook.xyz"> 
                Sebastián Andrade</a> . 2026
        </p>
    </footer>

</body>

</html>
