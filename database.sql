CREATE DATABASE stockmanager;

CREATE TABLE tabela_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_item VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL,
    data_validade DATE NOT NULL,
    almoxarifado VARCHAR(255) NOT NULL,
    codigo_item VARCHAR(255) NOT NULL
);