<?php

require_once "conexao.php";

$sql = "SELECT
            p.id_pedido,
            p.data_hora,
            p.status,
            p.valor_total,
            ip.id_produto,
            ip.quantidade,
            ip.preco_unitario,
            ip.subtotal,
            pr.nome AS nome_produto
        FROM pedido p
        INNER JOIN item_pedido ip
            ON p.id_pedido = ip.id_pedido
        INNER JOIN produto pr
            ON ip.id_produto = pr.id_produto
        ORDER BY p.id_pedido";

$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Pedidos Registrados</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <h1>Pedidos Registrados</h1>

    <?php if ($resultado && $resultado->num_rows > 0): ?>

        <table border="1">

            <thead>

                <tr>

                    <th>Pedido</th>
                    <th>Data e hora</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço unitário</th>
                    <th>Subtotal</th>
                    <th>Status</th>
                    <th>Valor total</th>

                </tr>

            </thead>

            <tbody>

                <?php while ($pedido = $resultado->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $pedido["id_pedido"]; ?>
                        </td>

                        <td>
                            <?php echo $pedido["data_hora"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars(
                                $pedido["nome_produto"]
                            ); ?>
                        </td>

                        <td>
                            <?php echo $pedido["quantidade"]; ?>
                        </td>

                        <td>
                            R$ <?php echo number_format(
                                $pedido["preco_unitario"],
                                2,
                                ",",
                                "."
                            ); ?>
                        </td>

                        <td>
                            R$ <?php echo number_format(
                                $pedido["subtotal"],
                                2,
                                ",",
                                "."
                            ); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars(
                                $pedido["status"]
                            ); ?>
                        </td>

                        <td>
                            R$ <?php echo number_format(
                                $pedido["valor_total"],
                                2,
                                ",",
                                "."
                            ); ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    <?php else: ?>

        <p>Nenhum pedido registrado.</p>

    <?php endif; ?>

</body>

</html>
