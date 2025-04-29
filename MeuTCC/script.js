// Login / Registro
const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

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

// Carrega carrinho e total do localStorage
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

function salvarCarrinho() {
  localStorage.setItem('carrinho', JSON.stringify(carrinho));
}

function adicionarAoCarrinho(nome, preco) {
  const item = carrinho.find(prod => prod.nome === nome);
  if (item) {
    item.qtd += 1;
  } else {
    carrinho.push({ nome, preco, qtd: 1 });
  }
  salvarCarrinho();
  atualizarCarrinho();
}

function removerItem(index) {
  carrinho.splice(index, 1);
  salvarCarrinho();
  atualizarCarrinho();
}

function alterarQuantidade(index, delta) {
  carrinho[index].qtd += delta;
  if (carrinho[index].qtd <= 0) {
    removerItem(index);
  } else {
    salvarCarrinho();
    atualizarCarrinho();
  }
}

function finalizarCompra() {
  alert('Compra finalizada com sucesso!');
  carrinho = [];
  salvarCarrinho();
  atualizarCarrinho();
}

function atualizarCarrinho() {
  const lista = document.getElementById('lista-carrinho');
  const contador = document.getElementById('contador');
  const totalSpan = document.getElementById('total');
  
  if (!lista) return;

  lista.innerHTML = '';
  let total = 0;

  carrinho.forEach((item, index) => {
    const li = document.createElement('li');
    const subtotal = item.preco * item.qtd;
    total += subtotal;
    
  li.innerHTML = `
    ${item.nome} - R$ ${item.preco.toFixed(2)} x ${item.qtd} = R$ ${(item.preco * item.qtd).toFixed(2)}
    <button class="btn-menos" onclick="alterarQuantidade(${index}, -1)">−</button>
    <button class="btn-mais" onclick="alterarQuantidade(${index}, 1)">+</button>
    <button class="remover" onclick="removerItem(${index})">Remover</button>
`;
    lista.appendChild(li);
  });

  if (contador) {
    const totalItens = carrinho.reduce((acc, item) => acc + item.qtd, 0);
    contador.textContent = totalItens;
  }

  if (totalSpan) {
    totalSpan.textContent = total.toFixed(2);
  }
}

function toggleCarrinho() {
  const box = document.getElementById('carrinho-detalhes');
  if (box) box.classList.toggle('oculto');
}

// Inicializa ao carregar
atualizarCarrinho();