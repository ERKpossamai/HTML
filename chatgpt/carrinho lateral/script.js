const carrinho = document.querySelector('.carrinho');
let contador = 0;
let total = 0;
const itensCarrinho = [];

document.querySelectorAll('.adicionar-carrinho').forEach(botao => {
  botao.addEventListener('click', (e) => {
    const produto = e.target.closest('.produto');
    const nome = produto.querySelector('h3').innerText;
    const preco = parseFloat(produto.dataset.preco);
    const imagem = produto.querySelector('img');
    const rectProduto = imagem.getBoundingClientRect();
    const rectCarrinho = carrinho.getBoundingClientRect();

    const imgClone = imagem.cloneNode(true);
    imgClone.style.position = 'absolute';
    imgClone.style.top = rectProduto.top + 'px';
    imgClone.style.left = rectProduto.left + 'px';
    imgClone.style.width = imagem.offsetWidth + 'px';
    imgClone.style.height = imagem.offsetHeight + 'px';
    imgClone.style.transition = 'all 1s ease-in-out';
    imgClone.style.zIndex = '1000';
    imgClone.style.borderRadius = '15px';
    document.body.appendChild(imgClone);

    setTimeout(() => {
      imgClone.style.top = rectCarrinho.top + 'px';
      imgClone.style.left = rectCarrinho.left + 'px';
      imgClone.style.width = '30px';
      imgClone.style.height = '30px';
      imgClone.style.opacity = '0';
    }, 50);

    setTimeout(() => {
      imgClone.remove();
      adicionarAoCarrinho(nome, preco);
    }, 1100);
  });
});

function adicionarAoCarrinho(nome, preco) {
  itensCarrinho.push({ nome, preco });
  contador++;
  total += preco;
  document.getElementById('contador-carrinho').innerText = contador;
  atualizarCarrinho();
}

function atualizarCarrinho() {
  const container = document.getElementById('itens-carrinho');
  container.innerHTML = '';
  itensCarrinho.forEach(item => {
    const div = document.createElement('div');
    div.textContent = `${item.nome} - R$ ${item.preco.toFixed(2)}`;
    container.appendChild(div);
  });
  document.getElementById('total-carrinho').innerText = total.toFixed(2);
}

function limparCarrinho() {
  itensCarrinho.length = 0;
  contador = 0;
  total = 0;
  document.getElementById('contador-carrinho').innerText = contador;
  atualizarCarrinho();
}
