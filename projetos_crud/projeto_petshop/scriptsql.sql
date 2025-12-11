CREATE DATABASE petshop;
USE petshop;

-- Tabela de Clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cep VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Funcionários
CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    funcao VARCHAR(50) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Consultas
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_funcionario INT NOT NULL,
    tipo ENUM('banho', 'tosa', 'consulta veterinario') NOT NULL,
    data_consulta DATETIME NOT NULL,
    observacoes TEXT,
    status ENUM('agendada', 'realizada', 'cancelada') DEFAULT 'agendada',
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_funcionario) REFERENCES funcionarios(id) ON DELETE CASCADE
);

-- Inserir alguns dados de exemplo
INSERT INTO clientes (nome, cep, email, telefone) VALUES 
('João Silva', '12345-678', 'joao@email.com', '(11) 9999-8888'),
('Maria Santos', '87654-321', 'maria@email.com', '(11) 7777-6666');

INSERT INTO funcionarios (nome, funcao) VALUES 
('Carlos Souza', 'Veterinário'),
('Ana Oliveira', 'Tosador'),
('Pedro Costa', 'Banhista');

INSERT INTO consultas (id_cliente, id_funcionario, tipo, data_consulta) VALUES 
(1, 1, 'consulta veterinario', '2024-01-15 10:00:00'),
(2, 2, 'tosa', '2024-01-15 14:30:00');