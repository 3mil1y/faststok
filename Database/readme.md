# Documentação das Tabelas do Banco de Dados (PT-BR)

Este documento descreve as principais tabelas utilizadas pelo sistema FastStok.

## Tabela `location`
Armazena os locais de armazenamento dos produtos.

| Campo      | Tipo         | Descrição                        |
|------------|--------------|----------------------------------|
| id         | int(11)      | Identificador único do local     |
| sector     | varchar(50)  | Setor do local                   |
| floor      | int(11)      | Andar do local                   |
| position   | int(11)      | Posição do local                 |

## Tabela `product`
Armazena as informações dos produtos cadastrados.

| Campo        | Tipo         | Descrição                           |
|--------------|--------------|-------------------------------------|
| product_id   | int(11)      | Identificador único do produto      |
| barcode      | varchar(50)  | Código de barras                    |
| name         | varchar(255) | Nome do produto                     |
| quantity     | int(11)      | Quantidade em estoque               |
| expiry_date  | date         | Data de validade                    |
| location_id  | int(11)      | Referência ao local de armazenamento|

- Chave estrangeira: `location_id` referencia o campo `id` da tabela `location`.

## Tabela `transfer`
Registra transferências de produtos.

| Campo | Tipo                         | Descrição                       |
|-------|------------------------------|---------------------------------|
| id    | int(11)                      | Identificador da transferência  |
| type  | enum('internal','external')  | Tipo de transferência           |
| date  | date                         | Data da transferência           |

## Tabela `user`
Armazena os usuários do sistema.

| Campo    | Tipo                     | Descrição                        |
|----------|--------------------------|----------------------------------|
| id       | int(11)                  | Identificador do usuário         |
| login    | varchar(100)             | Nome de login                    |
| password | varchar(255)             | Senha (hash)                     |
| role     | enum('admin','user')     | Perfil do usuário                |

# Database Tables Documentation (EN)

This document describes the main tables used by the FastStok system.

## Table `location`
Stores product storage locations.

| Field     | Type         | Description                     |
|-----------|--------------|---------------------------------|
| id        | int(11)      | Unique location identifier      |
| sector    | varchar(50)  | Storage sector                  |
| floor     | int(11)      | Storage floor                   |
| position  | int(11)      | Storage position                |

## Table `product`
Stores registered product information.

| Field       | Type         | Description                           |
|-------------|--------------|---------------------------------------|
| product_id  | int(11)      | Unique product identifier             |
| barcode     | varchar(50)  | Barcode                              |
| name        | varchar(255) | Product name                          |
| quantity    | int(11)      | Stock quantity                        |
| expiry_date | date         | Expiry date                           |
| location_id | int(11)      | Reference to storage location         |

- Foreign key: `location_id` references the `id` field in the `location` table.

## Table `transfer`
Records product transfers.

| Field | Type                        | Description                      |
|-------|-----------------------------|----------------------------------|
| id    | int(11)                     | Transfer identifier              |
| type  | enum('internal','external') | Transfer type                    |
| date  | date                        | Transfer date                    |

## Table `user`
Stores system users.

| Field    | Type                    | Description                      |
|----------|-------------------------|----------------------------------|
| id       | int(11)                 | User identifier                  |
| login    | varchar(100)            | Login name                       |
| password | varchar(255)            | Password (hash)                  |
| role     | enum('admin','user')    | User role                        |
