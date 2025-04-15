const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
    setTimeout(() => {
        wrapper.classList.remove('active');
    }, 300); 
});

let carrinho = [];
let carrinhoAberto = false;

function adicionarAoCarrinho(nome, preco) {
    carrinho.push({ nome, preco });
    atualizarCarrinho();
}

function atualizarCarrinho() {
    const lista = document.getElementById('lista_carrinho');
    const contador = document.querySelector('.contador');
    const totalSpan = document.getElementById('total');

    lista.innerHTML = ''; // Limpa a lista

    let total = 0;

    carrinho.forEach((item, index) => {
        const li = document.createElement('li');
        li.textContent = `${item.nome} - R$ ${item.preco.toFixed(2)}`;
        lista.appendChild(li);
        total += item.preco;
    });

    contador.textContent = carrinho.length;
    totalSpan.textContent = total.toFixed(2).replace('.', ',');
}

function toggleCarrinho() {
    const carrinhoDetalhes = document.getElementById('carrinho_detalhes');
    carrinhoAberto = !carrinhoAberto;

    if (carrinhoAberto) {
        carrinhoDetalhes.classList.remove('oculto');
    } else {
        carrinhoDetalhes.classList.add('oculto');
    }
}

function finalizarCompra() {
    if (carrinho.length === 0) {
        alert('Seu carrinho está vazio!');
        return;
    }

    let total = carrinho.reduce((acc, item) => acc + item.preco, 0);
    alert(`Compra finalizada!\nTotal: R$ ${total.toFixed(2).replace('.', ',')}`);

    // Limpar o carrinho
    carrinho = [];
    atualizarCarrinho();
    toggleCarrinho();
}
