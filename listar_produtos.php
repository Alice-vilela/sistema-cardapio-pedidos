<?php

require_once "conexao.php";

$sql = "SELECT
            id_produto,
            nome,
            descricao,
            categoria,
            preco,
            disponibilidade
        FROM produto
        ORDER BY id_produto";

$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Produtos Cadastrados</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <h1>Produtos Cadastrados</h1>

    <?php if ($resultado && $resultado->num_rows > 0): ?>

        <table border="1">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Disponibilidade</th>

                </tr>

            </thead>

            <tbody>

                <?php while ($produto = $resultado->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $produto["id_produto"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($produto["nome"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($produto["descricao"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($produto["categoria"]); ?>
                        </td>

                        <td>
                            R$ <?php echo number_format(
                                $produto["preco"],
                                2,
                                ",",
                                "."
                            ); ?>
                        </td>

                        <td>

                            <?php
                            if ($produto["disponibilidade"] == 1) {
                                echo "Disponível";
                            } else {
                                echo "Indisponível";
                            }
                            ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    <?php else: ?>

        <p>Nenhum produto cadastrado.</p>

    <?php endif; ?>

</body>

</html>
