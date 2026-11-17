CREATE TABLE IF NOT EXISTS usuarios (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nome   VARCHAR(120) NOT NULL,
    email  VARCHAR(150) NOT NULL,
    senha  VARCHAR(150) NOT NULL,
    perfil VARCHAR(30) 
);

CREATE TABLE IF NOT EXISTS produtos (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(150)NOT NULL,
    descricao TEXT NULL,
    preco     DECIMAL(10,2) NOT NULL,
    estoque   INT    NOT NULL,
    categoria VARCHAR(80) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nome, email, senha, perfil) VALUES
('Administrador', 'sebastian755',    '755!@#', 'admin'),
('Operador',      'sebastian755', '755!@#',   'operador');

INSERT INTO produtos (nome, descricao, preco, estoque, categoria) VALUES
('Mouse USB', 'Mouse para escritório',  35.90, 12, 'Periféricos'),
('Teclado',   'Teclado básico',         59.90,  7, 'Periféricos'),
('Monitor',   'Monitor de laboratório', 699.00, 3, 'Monitores');