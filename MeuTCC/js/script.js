// ===========================================
// 🔐 Login / Registro - Alternância de Tela
// ===========================================
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

// ===========================================
// 🛒 Carrinho - Inicialização Segura
// ===========================================
let carrinho = [];
try {
  carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
} catch (e) {
  console.warn('Erro ao carregar carrinho do localStorage:', e);
  carrinho = [];
}

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
  if (confirm('Deseja remover este item do carrinho?')) {
    carrinho.splice(index, 1);
    salvarCarrinho();
    atualizarCarrinho();
  }
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
  if (carrinho.length === 0) {
    alert('Seu carrinho está vazio!');
    return;
  }
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
    const subtotal = item.preco * item.qtd;
    total += subtotal;

    const li = document.createElement('li');
    li.innerHTML = `
      ${item.nome} - R$ ${item.preco.toFixed(2)} x ${item.qtd} = R$ ${subtotal.toFixed(2)}
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
  if (box) {
    box.classList.toggle('oculto');
  }
}

// Inicializa o carrinho ao carregar a página
atualizarCarrinho();


// Espera o carregamento do DOM
document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.querySelector('.menu-toggle');
  const navegation = document.querySelector('.navegation');

  // Adiciona/remover classe "active" para mostrar/ocultar o menu
  menuToggle.addEventListener('click', () => {
    navegation.classList.toggle('active');
  });

  // Fecha o menu ao clicar em qualquer link (opcional)
  document.querySelectorAll('.navegation a').forEach(link => {
    link.addEventListener('click', () => {
      navegation.classList.remove('active');
    });
  });
});

// Filtro por categoria
document.querySelectorAll('.menu button').forEach(button => {
  button.addEventListener('click', () => {
    const categoria = button.getAttribute('data-categoria');
    document.querySelectorAll('.produto').forEach(produto => {
      if (categoria === 'todos' || produto.classList.contains(categoria)) {
        produto.style.display = 'flex';
      } else {
        produto.style.display = 'none';
      }
    });
  });
});

// Filtro por pesquisa
document.getElementById('campo-pesquisa').addEventListener('input', () => {
  const termo = document.getElementById('campo-pesquisa').value.toLowerCase();
  document.querySelectorAll('.produto').forEach(produto => {
    const marca = produto.getAttribute('data-marca').toLowerCase();
    if (marca.includes(termo)) {
      produto.style.display = 'flex';
    } else {
      produto.style.display = 'none';
    }
  });
});

// Interação com botão "Saiba Mais"
document.getElementById("saibaMaisBtn").addEventListener("click", function () {
  alert("Obrigado por visitar! Confira nossos produtos!!!. 🚀");
  window.location.href = 'produto.html';
});