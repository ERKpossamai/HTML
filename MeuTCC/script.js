const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const loginForm = document.querySelector('.form-box.login');
const registerForm = document.querySelector('.form-box.register');
const btnLoginPopup = document.querySelector('.btnLogin-popup');

if (registerLink) {
  registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
  });
}

if (loginLink) {
  loginLink.addEventListener('click', () => {
    setTimeout(() => {
      wrapper.classList.remove('active');
    }, 300);
  });
}

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

  if (!lista || !contador || !totalSpan) return;

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

atualizarCarrinho();

function comprarProduto(nome, preco) {
  const params = new URLSearchParams({ nome, preco });
  window.location.href = `pagina-destino.html?${params.toString()}`;
}

