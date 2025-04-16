// Controlando a troca entre login e registro
const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const loginForm = document.querySelector('.form-box.login');
const registerForm = document.querySelector('.form-box.register');
const btnLoginPopup = document.querySelector('.btnLogin-popup');

// Função para alternar entre login e registro
registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
    setTimeout(() => {
        wrapper.classList.remove('active');
    }, 300); 
});

// Controlando a visibilidade do carrinho
const carrinhoBtn = document.querySelector('.carrinho'); // Botão do carrinho
const carrinhoDetalhes = document.getElementById('carrinho_detalhes'); // Detalhes do carrinho

// Função para mostrar ou esconder o carrinho
carrinhoBtn.addEventListener('click', () => {
    if (carrinhoDetalhes.style.display === 'none' || carrinhoDetalhes.style.display === '') {
        carrinhoDetalhes.style.display = 'block';
    } else {
        carrinhoDetalhes.style.display = 'none';
    }
});

// Exemplo de funcionalidade para adicionar itens ao carrinho
const addItemToCarrinho = (item) => {
    const itemElement = document.createElement('li');
    itemElement.textContent = item.name + ' - ' + item.price;
    carrinhoDetalhes.querySelector('ul').appendChild(itemElement);
};
    
