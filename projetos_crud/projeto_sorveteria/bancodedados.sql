-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS sorveteria;
USE sorveteria;

-- Tabela de Clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    endereco TEXT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Sabores
CREATE TABLE sabores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    disponivel BOOLEAN DEFAULT TRUE,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Encomendas
CREATE TABLE encomendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    data_entrega DATE NOT NULL,
    hora_entrega TIME NOT NULL,
    endereco_entrega TEXT,
    observacoes TEXT,
    status VARCHAR(20) DEFAULT 'pendente',
    total DECIMAL(10,2) DEFAULT 0,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id) ON DELETE CASCADE
);

-- Tabela de Itens da Encomenda
CREATE TABLE itens_encomenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_encomenda INT NOT NULL,
    id_sabor INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_encomenda) REFERENCES encomendas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sabor) REFERENCES sabores(id) ON DELETE CASCADE
);

-- Inserir sabores de exemplo
INSERT INTO sabores (nome, descricao, preco, tipo) VALUES 
('Chocolate', 'Sorvete cremoso de chocolate belga', 8.50, 'sorvete'),
('Morango', 'Sorvete de morango com pedaços da fruta', 8.00, 'sorvete'),
('Flocos', 'Sorvete de creme com flocos de chocolate', 9.00, 'sorvete'),
('Creme', 'Sorvete sabor baunilha', 7.50, 'sorvete'),
('Napolitano', 'Chocolate, morango e creme', 9.50, 'sorvete'),
('Pistache', 'Sorvete premium de pistache', 12.00, 'sorvete'),
('Chocolate Branco', 'Sorvete de chocolate branco', 9.00, 'sorvete'),
('Coco Queimado', 'Sorvete de coco queimado tradicional', 10.00, 'sorvete'),
('Chocolate c/ Amendoim', 'Picolé de chocolate com amendoim', 4.50, 'picole'),
('Coco', 'Picolé de coco cremoso', 4.00, 'picole'),
('Uva', 'Picolé de uva', 3.50, 'picole'),
('Manga', 'Picolé de manga', 4.00, 'picole'),
('Casquinha Simples', 'Casquinha tradicional', 2.50, 'casquinha'),
('Casquinha Chocolate', 'Casquinha com cobertura de chocolate', 3.50, 'casquinha'),
('Cascao', 'Cascão crocante', 4.00, 'cascao'),
('Taça Pequena', 'Taça com 2 bolas', 12.00, 'taca'),
('Taça Média', 'Taça com 3 bolas e calda', 16.00, 'taca'),
('Taça Grande', 'Taça com 4 bolas, calda e toppings', 20.00, 'taca');

-- Inserir clientes de exemplo
INSERT INTO clientes (nome, telefone, email, endereco) VALUES 
('Ana Silva', '(11) 9999-8888', 'ana@email.com', 'Rua das Flores, 123 - Centro'),
('Carlos Oliveira', '(11) 7777-6666', 'carlos@email.com', 'Av. Principal, 456 - Jardim'),
('Marina Costa', '(11) 5555-4444', 'marina@email.com', 'Rua do Comércio, 789 - Centro');

-- Inserir encomenda de exemplo
INSERT INTO encomendas (id_cliente, data_entrega, hora_entrega, endereco_entrega, observacoes, status, total) VALUES 
(1, '2024-12-20', '18:00:00', 'Rua das Flores, 123 - Centro', 'Entregar na portaria', 'confirmada', 25.50);

-- Inserir itens da encomenda de exemplo
INSERT INTO itens_encomenda (id_encomenda, id_sabor, quantidade, preco_unitario, subtotal) VALUES 
(1, 1, 2, 8.50, 17.00),
(1, 3, 1, 8.50, 8.50);

-- Criar índices para melhor performance
CREATE INDEX idx_encomendas_status ON encomendas(status);
CREATE INDEX idx_encomendas_data ON encomendas(data_entrega);
CREATE INDEX idx_sabores_tipo ON sabores(tipo);
CREATE INDEX idx_sabores_disponivel ON sabores(disponivel);

-- Visualizar os dados inseridos
SELECT 'Clientes:' AS '';
SELECT * FROM clientes;

SELECT 'Sabores:' AS '';
SELECT * FROM sabores;

SELECT 'Encomendas:' AS '';
SELECT * FROM encomendas;

SELECT 'Itens Encomenda:' AS '';
SELECT * FROM itens_encomenda;