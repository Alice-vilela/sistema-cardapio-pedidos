<?php

require_once "conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_produto = $_POST["id_produto"];
    $quantidade = $_POST["quantidade"];

    // Busca o preço do produto cadastrado
    $sql_produto = "SELECT preco FROM produto WHERE id_produto = ?";

    $stmt_produto = $conexao->prepare($sql_produto);
    $stmt_produto->bind_param("i", $id_produto);
    $stmt_produto->execute();

    $resultado = $stmt_produto->get_result();

    if ($resultado->num_rows > 0) {

        $produto = $resultado->fetch_assoc();

        $preco_unitario = $produto["preco"];
        $subtotal = $preco_unitario * $quantidade;

        // Inicia uma transação
        $conexao->begin_transaction();

        try {

            // Cadastra o pedido
            $sql_pedido = "INSERT INTO pedido
                           (data_hora, status, valor_total)
                           VALUES (NOW(), 'Pendente', ?)";

            $stmt_pedido = $conexao->prepare($sql_pedido);
            $stmt_pedido->bind_param("d", $subtotal);
            $stmt_pedido->execute();

            // Recupera o ID do pedido criado
            $id_pedido = $conexao->insert_id;

            // Cadastra o item do pedido
            $sql_item = "INSERT INTO item_pedido
                         (id_pedido, id_produto, quantidade, preco_unitario, subtotal)
                         VALUES (?, ?, ?, ?, ?)";

            $stmt_item = $conexao->prepare($sql_item);

            $stmt_item->bind_param(
                "iiidd",
                $id_pedido,
                $id_produto,
                $quantidade,
                $preco_unitario,
                $subtotal
            );

            $stmt_item->execute();

            // Confirma as operações
            $conexao->commit();

            $mensagem = "Pedido registrado com sucesso! Valor total: R$ "
                      . number_format($subtotal, 2, ",", ".");

            $stmt_pedido->close();
            $stmt_item->close();

        } catch (Exception $erro) {

            // Cancela as operações caso ocorra algum erro
            $conexao->rollback();

            $mensagem = "Erro ao registrar o pedido.";
        }

    } else {

        $mensagem = "Produto não encontrado.";
    }

    $stmt_produto->close();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Registrar Pedido</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <h1>Registrar Pedido</h1>

    <?php if ($mensagem != ""): ?>

        <p><?php echo $mensagem; ?></p>

    <?php endif; ?>

    <form method="POST">

        <label for="id_produto">
            Código do produto:
        </label>

        <input
            type="number"
            id="id_produto"
            name="id_produto"
            min="1"
            required
        >

        <label for="quantidade">
            Quantidade:
        </label>

        <input
            type="number"
            id="quantidade"
            name="quantidade"
            min="1"
            required
        >

        <button type="submit">
            Registrar pedido
        </button>

    </form>

</body>

</html>
