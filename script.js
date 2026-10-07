// Sistema de Cardápio e Pedidos para Restaurante

document.addEventListener("DOMContentLoaded", function () {

    // Confirmação antes do cadastro de produtos
    const formularioProduto = document.querySelector(
        'form[action="cadastro_produto.php"]'
    );

    if (formularioProduto) {
        formularioProduto.addEventListener("submit", function (evento) {

            const nome = document.querySelector("#nome").value.trim();
            const preco = parseFloat(
                document.querySelector("#preco").value
            );

            if (nome === "" || isNaN(preco) || preco < 0) {
                evento.preventDefault();
                alert("Preencha corretamente os dados do produto.");
                return;
            }

            if (!confirm("Deseja cadastrar este produto?")) {
                evento.preventDefault();
            }
        });
    }

    // Confirmação antes do registro de pedidos
    const formularioPedido = document.querySelector(
        'form[action="registrar_pedido.php"]'
    );

    if (formularioPedido) {
        formularioPedido.addEventListener("submit", function (evento) {

            const produtos = document.querySelectorAll(
                'select[name="id_produto[]"]'
            );

            const quantidades = document.querySelectorAll(
                'input[name="quantidade[]"]'
            );

            let possuiProduto = false;

            produtos.forEach(function (produto, indice) {

                const quantidade = parseInt(
                    quantidades[indice].value,
                    10
                );

                if (produto.value !== "" && quantidade > 0) {
                    possuiProduto = true;
                }
            });

            if (!possuiProduto) {
                evento.preventDefault();
                alert("Selecione pelo menos um produto e sua quantidade.");
                return;
            }

            if (!confirm("Deseja registrar este pedido?")) {
                evento.preventDefault();
            }
        });
    }

});
