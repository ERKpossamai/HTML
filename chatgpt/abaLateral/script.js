const sidebar = document.getElementById("sidebar");
const openBtn = document.getElementById("openSidebar");
const closeBtn = document.getElementById("closeSidebar");
const productList = document.getElementById("product-list");

openBtn.addEventListener("click", () => {
  sidebar.classList.add("show");
  filterProducts('todos'); // Mostrar todos ao abrir
});

closeBtn.addEventListener("click", () => {
  sidebar.classList.remove("show");
});

const produtos = [
  { nome: "Camiseta Dry Fit", preco: 49.9, categoria: "roupas", imagem: "img/camisa.jpg" },
  { nome: "Short Fitness", preco: 39.9, categoria: "roupas", imagem: "img/short.jpg" },
  { nome: "Shaker 600ml", preco: 25.0, categoria: "acessorios", imagem: "img/shaker.jpg" },
  { nome: "Creatina 300g", preco: 89.9, categoria: "suplementos", imagem: "img/creatina.jpg" },
  { nome: "Whey Protein", preco: 159.9, categoria: "suplementos", imagem: "img/whey.jpg" }
];

function filterProducts(categoria) {
  productList.innerHTML = '';

  const filtrados = categoria === 'todos'
    ? produtos
    : produtos.filter(p => p.categoria === categoria);

  filtrados.forEach(produto => {
    const div = document.createElement("div");
    div.classList.add("product");

    div.innerHTML = `
      <img src="${produto.imagem}" alt="${produto.nome}">
      <div>
        <p><strong>${produto.nome}</strong></p>
        <p>R$ ${produto.preco.toFixed(2)}</p>
      </div>
    `;
    productList.appendChild(div);
  });
}
