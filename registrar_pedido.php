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

    foreach ($ids as $indice => $id_produto) {

        $id_produto = (int) $id_produto;
        $quantidade = (int) ($quantidades[$indice] ?? 0);

        if ($id_produto <= 0 || $quantidade <= 0) {
            continue;
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
            $subtotal = round($preco_unitario * $quantidade, 2);

            $itens[] = [
                "id_produto" => $id_produto,
                "quantidade" => $quantidade,
                "preco_unitario" => $preco_unitario,
                "subtotal" => $subtotal
            ];

            $valor_total += $subtotal;
        }

        $stmt->close();
    }

    if (count($itens) > 0) {

        try {

            $conexao->begin_transaction();

            $status = "Pendente";
            $valor_total = round($valor_total, 2);

            // Inserir pedido
            $sql = "INSERT INTO pedido
                    (data_hora, status, valor_total)
                    VALUES (NOW(), ?, ?)";

            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sd", $status, $valor_total);
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
