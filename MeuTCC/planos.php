<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Conheça os planos da academia Estação do Corpo e escolha o que melhor se adapta às suas necessidades.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planos</title>
    <link rel="stylesheet" href="css/planos.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
</head>
<body>
    <header>
        <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo">
        <h1>Estação do corpo</h1>

        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav class="navegation">
            <ul>
                <li><a href="inicio.php">Início</a></li>
                <li><button class="btnLogin-popup">Planos</button></li>
                <li><a href="produto.html">Produtos</a></li>
                <li><a href="local.html">Localização</a></li>
                <li><a href="servicos.php">Servicos</a></li>
                   </ul>
        </nav>
    </header>
    
    <main>
        <div class="produtos_car">
            <img class="img-pl1" src="img/goku.png" alt="Plano Mensal" />
            <h2>Plano Mensal</h2>
            <p class="preco">R$119,90</p>
            <button onclick="window.location.href='checkout.php?plano=mensal'">Escolher Plano</button>
        </div>

        <div class="produtos_car">
            <img class="img-pl2" src="img/all migth.webp" alt="Plano Semestral" />
            <h2>Plano Semestral</h2>
            <p class="preco">R$595,90</p>
            <button onclick="window.location.href='checkout.php?plano=semestral'">Escolher Plano</button>
        </div>

        <div class="produtos_car">
            <img class="img-pl3" src="img/hulk1.webp" alt="Plano Anual" />
            <h2>Plano Anual</h2>
            <p class="preco">R$895,90</p>
            <button onclick="window.location.href='checkout.php?plano=anual'">Escolher Plano</button>
        </div>
    </main>

    <footer>
        &copy; 2025 Estação do corpo. Todos os direitos reservados a (Lucas e Erick)
    </footer>
    
    </body>
</html>