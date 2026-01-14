-- Banco de Dados LogiDrone (Legado - Refatorado PT-BR)
-- Criado por: Sobrinho (2024) - Refatorado para PT-BR

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    preco DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS drones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(50),
    nivel_bateria INT DEFAULT 100,
    status VARCHAR(20) DEFAULT 'OCIOSO' -- OCIOSO, ENTREGANDO, RETORNANDO, CARREGANDO
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100),
    produto_id INT,
    quantidade INT DEFAULT 1,
    preco_total DECIMAL(10, 2),
    status VARCHAR(20) DEFAULT 'PENDENTE', -- PENDENTE, PAGO, ENVIADO, ENTREGUE
    drone_id INT DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (drone_id) REFERENCES drones(id)
);

-- Carga inicial (Seed) em PT-BR
INSERT INTO produtos (nome, estoque, preco) VALUES 
('Hélice Drone X1', 10, 50.00),
('Bateria Ultra Pack', 50, 150.00),
('Controle Pro Stick', 5, 200.00);

INSERT INTO drones (modelo, status) VALUES 
('Drone-Alfa', 'OCIOSO'),
('Drone-Beta', 'OCIOSO'),
('Drone-Gama', 'OCIOSO');
