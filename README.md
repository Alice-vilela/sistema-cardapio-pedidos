(```)
# Sistema de Cardápio e Pedidos para Restaurante

## Sobre o projeto

Este projeto apresenta a proposta de um sistema para auxiliar no gerenciamento de produtos e pedidos de um restaurante.

O sistema foi desenvolvido como parte de uma atividade acadêmica do curso de Análise e Desenvolvimento de Sistemas, integrando conhecimentos de análise de requisitos, modelagem de dados, programação e desenvolvimento web.

## Objetivo

Organizar o cadastro de produtos, a consulta do cardápio e o registro de pedidos, facilitando o acesso às informações e o controle das operações do restaurante.

## Funcionalidades

- Cadastro de produtos
- Consulta de produtos cadastrados
- Registro de pedidos
- Cálculo do valor total dos pedidos
- Consulta de pedidos

A atualização de produtos e do status dos pedidos faz parte dos requisitos previstos para o sistema.

## Tecnologias utilizadas

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL
- GitHub

## Estrutura do projeto

```text
sistema-cardapio-pedidos/
├── README.md
├── database.sql
├── conexao.php
├── cadastro_produto.php
├── registrar_pedido.php
├── listar_produtos.php
├── listar_pedidos.php
├── index.php
├── style.css
└── script.js
```

## Banco de dados

O banco de dados, denominado `restaurante`, possui três tabelas principais:

### produto
Armazena o identificador, nome, descrição, categoria, preço e disponibilidade dos produtos.

### pedido
Armazena o identificador, data e hora, status e valor total de cada pedido.

### item_pedido
Armazena os produtos associados aos pedidos, suas quantidades, preços unitários e subtotais.

## Organização do desenvolvimento

O projeto foi organizado em cinco etapas:

1. Análise de requisitos
2. Modelagem do sistema
3. Prototipagem das interfaces
4. Desenvolvimento das funcionalidades
5. Planejamento e validação dos testes

## Execução

O código PHP foi estruturado para utilizar um servidor com suporte a PHP e um banco de dados MySQL.

O arquivo `database.sql` contém os comandos necessários para criar o banco e suas tabelas.

O repositório disponibiliza o código-fonte do projeto. A publicação no GitHub, por si só, não executa a aplicação PHP nem comprova os resultados dos testes.

## Finalidade acadêmica

Projeto desenvolvido para aplicação prática dos conteúdos estudados no curso de Análise e Desenvolvimento de Sistemas.
(```)
