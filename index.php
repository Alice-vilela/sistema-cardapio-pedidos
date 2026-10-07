<?php
// Página inicial do Sistema de Cardápio e Pedidos
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Cardápio e Pedidos</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>Sistema de Cardápio e Pedidos</h1>
        <p>Gerenciamento de produtos e pedidos do restaurante</p>
    </header>

    <main>

        <h2>Painel Principal</h2>

        <p>
            Selecione uma das opções abaixo para acessar
            as funcionalidades do sistema.
        </p>

        <nav class="menu">

            <a href="cadastro_produto.php" class="botao">
                Cadastrar Produto
            </a>

            <a href="listar_produtos.php" class="botao">
                Consultar Cardápio
            </a>

            <a href="registrar_pedido.php" class="botao">
                Registrar Pedido
            </a>

            <a href="listar_pedidos.php" class="botao">
                Consultar Pedidos
            </a>

        </nav>

    </main>

    <footer>
        <p>
            Sistema de Cardápio e Pedidos para Restaurante
        </p>
        <p>Projeto Acadêmico - 2026</p>
    </footer>

</body>

</html>
