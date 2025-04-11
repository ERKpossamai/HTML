// Lista para armazenar os itens do carrinho
let carrinho = [];

// Função para adicionar um produto ao carrinho
function adicionarAoCarrinho(produto) {
    carrinho.push(produto);
    atualizarCarrinho();
    alert(`${produto} foi adicionado ao carrinho!`);
}

// Função para exibir os itens do carrinho no console (simulação básica)
function atualizarCarrinho() {
    console.clear();
    console.log('Itens no carrinho:');
    carrinho.forEach((item, index) => {
        console.log(`${index + 1}. ${item}`);
    });

    if (carrinho.length === 0) {
        console.log('Carrinho está vazio.');
    }
}
