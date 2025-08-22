<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
</head>
<body>

<?php
// Inicia sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: login.php");
    exit;
}
$nomeUsuario = $_SESSION['usuario_nome'];

include 'conexao.php';
?>

  <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark p-4">
        <h5 class="text-white h4">Collapsed content</h5>
        <span class="text-muted">Toggleable via the navbar brand.</span>
      </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
  </div>

<header>
  <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo">
  <h1>Estação do corpo</h1>

  <!-- Botão do menu hambúrguer -->
  <div class="menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
  </div>

  <nav class="navegation">
     <ul>
        <li><button class="btnLogin-popup">Inicio</button></li>
        <li><a href="planos.php">Planos</a></li>
        <li><a href="produto.html">Produtos</a></li>
        <li><a href="local.html">Localização</a></li>
        <li><a href="servicos.php">Serviços</a></li>
     </ul> 

     <div class="carrinho" onclick="toggleCarrinho()" aria-label="Carrinho de compras">
        <a href="carrinho.html">
            🛒<span id="contador" class="contador-carrinho">0</span>
        </a>
     </div>

             <!-- Dropdown do usuário -->
        <div class="user-dropdown">
            <button class="user-btn">
                👤 <?php echo $_SESSION['usuario_nome']; ?>
            </button>
            <div class="user-menu">
                <a href="ver_matricula.php">Meus Dados</a>
                <a href="logout.php">Sair</a>
            </div>
        </div>
    </nav>
</header>

<style>
/* Área do usuário */
.user-dropdown {
    position: relative;
    display: inline-block;
    margin-left: 15px;
}

.user-btn {
    background: transparent;
    border: none;
    color: #ff6600;
    font-weight: bold;
    cursor: pointer;
    padding: 8px 12px;
    font-size: 15px;
}

.user-btn:hover {
    color: #fff;
}

.user-menu {
    display: none;
    position: absolute;
    right: 0;
    background-color: #222;
    min-width: 160px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.3);
    z-index: 10;
}

.user-menu a {
    color: #fff;
    padding: 10px 16px;
    display: block;
    text-decoration: none;
    font-size: 14px;
}

.user-menu a:hover {
    background-color: #ff6600;
}

.user-dropdown:hover .user-menu {
    display: block;
}
</style>
  </nav>
</header>
    
<section>
   <h2>Quem Somos</h2>
   <p>
   Há mais de 3 anos, a <strong>Academia Estação do Corpo</strong> vem ajudando pessoas a se redescobrirem...
   </p>
   <p>
   Ao longo do tempo, ganhamos espaço no dia a dia de muita gente. Ver nossos alunos vivendo melhor e com mais disposição é o que nos move.
   </p>
   
   <h2>Nossos Valores</h2>
   <p>
   Aqui, a gente acredita em você. Nosso espaço é pensado pra te deixar à vontade...
   </p>
  
   <h2>O Futuro</h2>
   <p>
   Estamos sempre de olho nas novidades e investindo em tecnologia e equipamentos de ponta...
   </p>
</section>

<div class="ref-cariani">
  <img src="img/cariani.webp" alt="cariani">
  <div class="frase_cariani">
    “No momento que você sabe o que você come, você tem controle sobre sua vida.” 
    <br>
    <h6>- Renato Cariani</h6>
  </div>
</div>

<!-- Link para o Instagram -->
<a href="https://www.instagram.com/piscinaestacaodocorpo/" 
   class="instagram-link" 
   target="_blank" 
   rel="noopener noreferrer">
   <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram" class="icon">
   Siga-nos no Instagram!!!
</a>

<!-- Link para o Facebook -->
<a href="https://www.facebook.com/estacaodocorpocorbelia/" 
   class="facebook-link" 
   target="_blank" 
   rel="noopener noreferrer">
   <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" 
        alt="Facebook" 
        class="icon">
   Curta nossa página no Facebook
</a>

<footer>
  &copy; 2025 Estação do corpo. Todos os direitos reservados a (Lucas e Erick)
</footer>

<div class="oculto">
  <!-- Carrinho Detalhado -->
  <div id="carrinho-detalhes" class="oculto">
    <ul id="lista-carrinho"></ul>
    <p><strong>Total:</strong> R$ <span id="total">0.00</span></p>
    <button onclick="finalizarCompra()" class="finalizar">Finalizar Compra</button>
  </div>
</div>

<script>
  const menuToggle = document.getElementById('botaoMenu');
  const navegation = document.querySelector('.navegation');

  if(menuToggle){
    menuToggle.addEventListener('click', () => {
      navegation.classList.toggle('active');
    });
  }
</script>

<script async src="js/script.js"></script>
</body>
</html>
