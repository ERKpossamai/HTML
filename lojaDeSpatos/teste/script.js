let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
let total = parseFloat(localStorage.getItem('total')) || 0;

function adicionarAoCarrinho(nome, preco) {
  carrinho.push({ nome, preco });
  total += preco;
  salvarCarrinho();
  atualizarCarrinho();
}

function removerDoCarrinho(index) {
  total -= carrinho[index].preco;
  carrinho.splice(index, 1);
  salvarCarrinho();
  atualizarCarrinho();
}

function finalizarCompra() {
  alert('Compra finalizada com sucesso!');
  carrinho = [];
  total = 0;
  salvarCarrinho();
  atualizarCarrinho();
}

function atualizarCarrinho() {
  const lista = document.getElementById('lista-carrinho');
  const contador = document.getElementById('contador');
  const totalSpan = document.getElementById('total');

  lista.innerHTML = '';

  carrinho.forEach((item, index) => {
    const li = document.createElement('li');
    li.innerHTML = `${item.nome} - R$ ${item.preco.toFixed(2)} 
      <button class="remover" onclick="removerDoCarrinho(${index})">Remover</button>`;
    lista.appendChild(li);
  });

  contador.textContent = carrinho.length;
  totalSpan.textContent = total.toFixed(2);
}

function salvarCarrinho() {
  localStorage.setItem('carrinho', JSON.stringify(carrinho));
  localStorage.setItem('total', total.toString());
}

function toggleCarrinho() {
  const box = document.getElementById('carrinho-detalhes');
  box.classList.toggle('oculto');
}

atualizarCarrinho(); // Carrega dados salvos ao abrir a página
