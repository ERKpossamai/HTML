<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindos à Estação do Corpo</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            background-color: #000;
        }
        .hero-section {
            position: relative;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            padding: 0 20px;
            /* Adicione sua imagem de fundo aqui */
            background-image: url('caminho/para/sua/imagem.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        .content {
            position: relative;
            z-index: 2;
        }
        .content h1 {
            font-size: 3.5em;
            margin-bottom: 20px;
            color: #ffcc00;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        .cta-button {
            display: inline-block;
            padding: 15px 40px;
            margin-top: 30px;
            background-color: #00ff00;
            color: #000;
            font-weight: bold;
            text-decoration: none;
            border-radius: 50px;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: #00e600;
        }
        .info-section {
            margin: 50px auto;
            max-width: 800px;
            padding: 40px;
            border: 3px solid #00ff00; /* A borda verde agora envolve a seção de informações */
            border-radius: 10px;
            background-color: #1a1a1a;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            text-align: center; /* Centraliza o conteúdo */
        }
        .info-section h2 {
            color: #ffcc00;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .info-list {
            list-style: none;
            padding: 0;
            font-size: 1.2em;
        }
        .info-list li {
            margin-bottom: 10px;
        }
        .info-list a {
            color: #00ff00;
            text-decoration: none;
        }
        .info-list a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header>
        <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo">
        <h1>Estação do corpo</h1>
        <nav class="navegation">
            <ul>

                <li><a href="login.php">Faça parte do time!!</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="hero-section">
            <div class="overlay"></div>
            <div class="content">
                <h1>Bem-vindos à melhor academia de Corbélia</h1>
                <p>Venha fazer parte do nosso time maromba!!!!!</p>
                <a href="login.php" class="cta-button">Junte-se a nós agora!</a>
            </div>
        </div>

        <section class="info-section">
            <h2>Horários e Contato</h2>
            <ul class="info-list">
                <li><strong>Segunda a Sexta:</strong> 06:00 - 22:00</li>
                <li><strong>Sábados:</strong> 08:00 - 18:00</li>
                <li><strong>Domingos e Feriados:</strong> Fechado</li>
                <br>
                <li><strong>WhatsApp:</strong> <a href="https://wa.me/554599170609" target="_blank">(45) 9917-0609</a></li>
            </ul>
        </section>

    </main>

    <footer>
        &copy; 2025 Estação do corpo. Todos os direitos reservados.
    </footer>

</body>
</html>