<?php

require_once "conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $categoria = trim($_POST["categoria"] ?? "");
    $preco = filter_var(
        $_POST["preco"] ?? null,
        FILTER_VALIDATE_FLOAT
    );

    $disponibilidade = isset($_POST["disponibilidade"]) ? 1 : 0;

    if ($nome === "" || $categoria === "" ||
        $preco === false || $preco < 0) {

        $mensagem = "Preencha corretamente os dados do produto.";

    } else {

        $sql = "INSERT INTO produto
                (nome, descricao, categoria, preco, disponibilidade)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param(
            "sssdi",
            $nome,
            $descricao,
            $categoria,
            $preco,
            $disponibilidade
        );

        if ($stmt->execute()) {
            $mensagem = "Produto cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar o produto.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Produto</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Cadastro de Produto</h1>

    <?php if ($mensagem != ""): ?>
        <p>
            <?php echo htmlspecialchars($mensagem); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="cadastro_produto.php">

        <label for="nome">Nome do produto:</label>
        <input
            type="text"
            id="nome"
            name="nome"
            required
        >

        <label for="descricao">Descrição:</label>
        <textarea
            id="descricao"
            name="descricao"
        ></textarea>

        <label for="categoria">Categoria:</label>
        <input
            type="text"
            id="categoria"
            name="categoria"
            required
        >

        <label for="preco">Preço:</label>
        <input
            type="number"
            id="preco"
            name="preco"
            step="0.01"
            min="0"
            required
        >

        <label>
            <input
                type="checkbox"
                name="disponibilidade"
                checked
            >
            Produto disponível
        </label>

        <button type="submit">
            Cadastrar produto
        </button>

    </form>

    <p>
        <a href="listar_produtos.php">
            Consultar cardápio
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
