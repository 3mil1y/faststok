-- Remover tabela usuario se já existir
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    permissao ENUM('admin', 'usuario') NOT NULL
);

-- Remover tabela endereco se já existir
DROP TABLE IF EXISTS endereco;

CREATE TABLE endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setor VARCHAR(50) NOT NULL,
    andar INT NOT NULL,
    posicao INT NOT NULL
);

-- Remover tabela produto se já existir
DROP TABLE IF EXISTS produto;

CREATE TABLE produto (
    idProduto INT AUTO_INCREMENT PRIMARY KEY,  -- Novo campo idProduto como chave primária
    codBarras VARCHAR(50) NOT NULL,           -- Código de barras pode se repetir
    nome VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL CHECK (quantidade >= 0),
    validade DATE NOT NULL,
    idEndereco INT NOT NULL,
    FOREIGN KEY (idEndereco) REFERENCES endereco(idEndereco) ON DELETE CASCADE
);