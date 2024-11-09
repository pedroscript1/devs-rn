-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS associacao;
USE associacao;

-- Tabela de Associados
CREATE TABLE IF NOT EXISTS associados (
    associado_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    data_filiacao DATE NOT NULL
);

-- Tabela de Anuidades
CREATE TABLE IF NOT EXISTS anuidades (
    anuidade_id INT AUTO_INCREMENT PRIMARY KEY,
    ano INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);

-- Tabela de Pagamentos
CREATE TABLE IF NOT EXISTS pagamentos (
    pagamento_id INT AUTO_INCREMENT PRIMARY KEY,
    associado_id INT,
    anuidade_id INT,
    status BOOLEAN DEFAULT 0,
    FOREIGN KEY (associado_id) REFERENCES associados(associado_id) ON DELETE CASCADE,
    FOREIGN KEY (anuidade_id) REFERENCES anuidades(anuidade_id) ON DELETE CASCADE
);
