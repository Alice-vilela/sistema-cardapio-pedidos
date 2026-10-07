<?php

require_once "conexao.php";

$mensagem = "";

// Consultar produtos disponíveis
$sql = "SELECT id_produto, nome, preco
        FROM produto
        WHERE disponibilidade = 1
        ORDER BY nome";

$produtos = $conexao->query($sql);

// Registrar pedido
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $ids = $_POST["id_produto"] ?? [];
    $quantidades = $_POST["quantidade"] ?? [];

    $itens = [];
    $valor_total = 0;
    $pedido_valido = true;

    foreach ($ids as $indice => $id_produto) {

        $id_produto = (int) $id_produto;
        $quantidade = (int) ($quantidades[$indice] ?? 0);

        if ($id_produto <= 0 && $quantidade === 0) {
            continue;
        }

        if ($id_produto <= 0 || $quantidade <= 0) {
            $pedido_valido = false;
            break;
        }

        $sql = "SELECT preco FROM produto
                WHERE id_produto = ?
                AND disponibilidade = 1";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_produto);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($produto = $resultado->fetch_assoc()) {

            $preco_unitario = (float) $produto["preco"];
            $subtotal = round(
                $preco_unitario * $quantidade,
                2
            );

            $itens[] = [
                "id_produto" => $id_produto,
                "quantidade" => $quantidade,
                "preco_unitario" => $preco_unitario,
                "subtotal" => $subtotal
            ];

            $valor_total += $subtotal;

        } else {
            $pedido_valido = false;
        }

        $stmt->close();

        if (!$pedido_valido) {
            break;
        }
    }

    if ($pedido_valido && count($itens) > 0) {

        try {

            $conexao->begin_transaction();

            $status = "Pendente";
            $valor_total = round($valor_total, 2);

            // Inserir pedido
            $sql = "INSERT INTO pedido
                    (data_hora, status, valor_total)
                    VALUES (NOW(), ?, ?)";

            $stmt = $conexao->prepare($sql);

            $stmt->bind_param(
                "sd",
                $status,
                $valor_total
            );

            $stmt->execute();

            $id_pedido = $conexao->insert_id;

            $stmt->close();

            // Inserir itens do pedido
            $sql = "INSERT INTO item_pedido
                    (id_pedido, id_produto, quantidade,
                     preco_unitario, subtotal)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conexao->prepare($sql);

            foreach ($itens as $item) {

                $stmt->bind_param(
                    "iiidd",
                    $id_pedido,
                    $item["id_produto"],
                    $item["quantidade"],
                    $item["preco_unitario"],
                    $item["subtotal"]
                );

                $stmt->execute();
            }

            $stmt->close();

            $conexao->commit();

            $mensagem = "Pedido registrado com sucesso! "
                      . "Número: " . $id_pedido
                      . " | Total: R$ "
                      . number_format(
                          $valor_total,
                          2,
                          ",",
                          "."
                      );

        } catch (Exception $e) {

            $conexao->rollback();

            $mensagem = "Erro ao registrar pedido.";
        }

    } else {

        $mensagem = "Selecione produtos disponíveis "
                  . "e informe quantidades válidas.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar Pedido</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Registro de Pedido</h1>

    <?php if ($mensagem != ""): ?>
        <p>
            <?php echo htmlspecialchars($mensagem); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="registrar_pedido.php">

        <h2>Selecionar Produtos</h2>

        <?php for ($i = 0; $i < 5; $i++): ?>

            <div>

                <label>Produto:</label>

                <select name="id_produto[]">

                    <option value="">
                        Selecione
                    </option>

                    <?php

                    if ($produtos) {

                        $produtos->data_seek(0);

                        while (
                            $produto = $produtos->fetch_assoc()
                        ):

                    ?>

                        <option
                            value="<?php echo $produto['id_produto']; ?>"
                        >
                            <?php

                            echo htmlspecialchars($produto["nome"])
                                 . " - R$ "
                                 . number_format(
                                     $produto["preco"],
                                     2,
                                     ",",
                                     "."
                                 );

                            ?>
                        </option>

                    <?php

                        endwhile;
                    }

                    ?>

                </select>

                <label>Quantidade:</label>

                <input
                    type="number"
                    name="quantidade[]"
                    min="0"
                    step="1"
                    value="0"
                >

            </div>

        <?php endfor; ?>

        <button type="submit">
            Registrar Pedido
        </button>

    </form>

    <p>
        <a href="listar_pedidos.php">
            Consultar pedidos
        </a>
    </p>

    <p>
        <a href="index.php">
            Voltar ao início
        </a>
    </p>

    <script src="script.js"></script>

</body>

</html>
