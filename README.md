
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

A atualização de produtos e do status dos pedidos faz parte dos requisitos previstos para o sistema, mas não está implementada na versão atual do código.

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

O banco de dados foi denominado `restaurante` e possui três tabelas principais.

### Tabela produto

Responsável por armazenar as informações dos produtos cadastrados no cardápio.

Campos:
- id_produto
- nome
- descricao
- categoria
- preco
- disponibilidade

### Tabela pedido

Responsável por armazenar os dados gerais dos pedidos realizados.

Campos:
- id_pedido
- data_hora
- status
- valor_total

### Tabela item_pedido

Responsável por armazenar os produtos associados a cada pedido, suas quantidades e valores.

Campos:
- id_item
- id_pedido
- id_produto
- quantidade
- preco_unitario
- subtotal

As tabelas possuem relacionamentos que permitem associar os produtos aos pedidos registrados.

## Organização do desenvolvimento

O projeto foi organizado em cinco etapas:

1. Análise de requisitos
2. Modelagem do sistema
3. Prototipagem das interfaces
4. Desenvolvimento das funcionalidades
5. Planejamento e validação dos testes

## Funcionalidades desenvolvidas no código

### Cadastro de produtos

A funcionalidade de cadastro permite informar o nome, a descrição, a categoria, o preço e a disponibilidade de um produto.

Os dados são enviados ao arquivo `cadastro_produto.php`, responsável pela validação das informações e pelo comando de inserção na tabela `produto`.

### Registro de pedidos

A funcionalidade de registro de pedidos permite selecionar produtos disponíveis e informar suas quantidades.

O sistema calcula os subtotais e o valor total, preparando o registro nas tabelas `pedido` e `item_pedido`.

O status inicial definido para os pedidos é `Pendente`.

### Consulta de produtos

O arquivo `listar_produtos.php` é responsável pela consulta dos produtos cadastrados no banco de dados.

### Consulta de pedidos

O arquivo `listar_pedidos.php` é responsável pela consulta dos pedidos registrados.

## Execução do projeto

A aplicação foi estruturada em PHP, com conexão a um banco de dados MySQL.

O arquivo `database.sql` contém os comandos necessários para criar o banco de dados e suas tabelas.

Para executar a aplicação, é necessário utilizar um ambiente com suporte a PHP e MySQL, configurar a conexão e acessar o arquivo `index.php` pelo servidor.

O repositório disponibiliza o código-fonte do projeto. A publicação no GitHub não representa, por si só, a execução ou a validação das funcionalidades.

## Finalidade acadêmica

Este projeto foi elaborado para aplicar conhecimentos adquiridos durante o curso de Análise e Desenvolvimento de Sistemas, envolvendo levantamento de requisitos, modelagem, prototipagem, programação e organização do código-fonte.
