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
