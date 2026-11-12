<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Meu Portfolio</title>

    @vite(['resources/css/05-portfolio.css'])

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
                Alguns projetos que desenvolvi durante o curso:
            </p>
            <div class="projetos-container">
            <div class="projeto-card">
                <div class="projeto-numero">
                    01
                </div>
                    <h3>Verificação de idade</h3>
                    <p>
                        Sistema desenvolvido para praticar
                        formulários e manipulação de dados.
                    </p>
                    <div class="tecnologias">
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>PHP</span>
                    </div>
                    <a href="{{ route('Idade') }}" class="link-projeto">
                        Ver projeto →
                    </a>
                </div>
                <div class="projeto-card">
                    <div class="projeto-numero">
                        02
                    </div>
                    <h3>Cadastro de notas</h3>
                    <p>
                        Sistema desenvolvido para praticar
                        formulários e manipulação de dados.
                    </p>
                    <div class="tecnologias">
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>PHP</span>
                    </div>
                    <a href="/?rota=notas" class="link-projeto">
                        Ver projeto →
                    </a>
                </div>
                <div class="projeto-card">
                    <div class="projeto-numero">
                        03
                    </div>
                    <h3>Cadastro de jogos</h3>
                    <p>
                        Sistema desenvolvido para praticar
                        formulários e manipulação de dados.
                    </p>
                    <div class="tecnologias">
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>PHP</span>
                    </div>
                    <a href="/?rota=jogos" class="link-projeto">
                        Ver projeto →
                    </a>
                </div>
                <div class="projeto-card">
                    <div class="projeto-numero">
                        04
                    </div>
                    <h3>Login Básico</h3>
                    <p>
                        Login simples desenvolvido para praticar
                        formulários e manipulação de dados.
                    </p>
                    <div class="tecnologias">
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>PHP</span>
                    </div>
                    <a href="/?rota=login-basico" class="link-projeto">
                        Ver projeto →
                    </a>
                </div>  
                <div class="projeto-card">
                    <div class="projeto-numero">
                        05
                    </div>
                    <h3>Sistema Helpdesk para Gerenciar Chamados</h3>
                    <p>
                        Sistema para registrar chamados, acompanhar o status
                        e organizar atendimentos de suporte.
                    </p>
                    <div class="tecnologias">
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>PHP</span>
                    </div>
                    <a href="/?rota=helpdesk" class="link-projeto">
                        Ver projeto →
                    </a>
                </div>
                 <div class="projeto-card">
                    <div class="projeto-numero">
                        06
                    </div>
                    <h3>Sistema para Gerenciar Cadastro de Máquinas</h3>
                    <p>
                        Sistema em PHP que permite cadastrar máquinas industriais, registrar a quantidade produzida e visualizar
                        os dados dinamicamente, aplicando conceitos de Progamação Orientada a Objetos, como herença, abstração e polimorfismo.
                    </p>
                    <div class="tecnologias">
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>PHP</span>
                    </div>
                    <a href="/?rota=poo2" class="link-projeto">
                        Ver projeto →
                    </a>
                </div>
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