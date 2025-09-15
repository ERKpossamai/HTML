<?php
// Inicia a sessão e inclui o arquivo de conexão
session_start();
include 'conexao.php'; // Certifique-se de que este arquivo se conecta ao banco de dados com PDO

$plano_contratado = false;
$plano_atual = null;

// Verifica se o usuário está logado
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    
    // Consulta o banco de dados para verificar se o usuário já tem um plano
    try {
        $sql = "SELECT plano FROM planos WHERE usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->execute();
        $plano_atual = $stmt->fetchColumn();
        
        if ($plano_atual) {
            $plano_contratado = true;
        }
    } catch (PDOException $e) {
        // Em caso de erro, apenas defina o status como falso para não impedir o usuário
        $plano_contratado = false;
    }
}
?>

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

    <style>
        /* Estilos adicionais para as novas mensagens */
        .plan-button-container {
            min-height: 50px; /* Garante que o container não encolha */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .message-container {
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .message-container p {
            font-size: 0.9em;
            margin: 0;
            color: #ccc;
        }
        .message-container .btn {
            display: block;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .message-container .btn:hover {
            background-color: #45a049;
        }
        /* Estilo para desabilitar o botão de escolher plano */
        .disabled-button {
            background-color: #555;
            cursor: not-allowed;
            opacity: 0.6;
            pointer-events: none; /* Impede cliques */
        }
    </style>
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
            <div class="plan-button-container">
                <?php if ($plano_contratado): ?>
                    <div class="message-container">
                        <p>Você já possui um plano.</p>
                        <a href="editar-plano.php" class="btn">Editar seu plano</a>
                    </div>
                <?php else: ?>
                    <button onclick="window.location.href='checkout.php?plano=mensal'">Escolher Plano</button>
                <?php endif; ?>
            </div>
        </div>

        <div class="produtos_car">
            <img class="img-pl2" src="img/all migth.webp" alt="Plano Semestral" />
            <h2>Plano Semestral</h2>
            <p class="preco">R$595,90</p>
            <div class="plan-button-container">
                <?php if ($plano_contratado): ?>
                    <div class="message-container">
                        <p>Você só pode contratar um plano por vez.</p>
                    </div>
                <?php else: ?>
                    <button onclick="window.location.href='checkout.php?plano=semestral'">Escolher Plano</button>
                <?php endif; ?>
            </div>
        </div>

        <div class="produtos_car">
            <img class="img-pl3" src="img/hulk1.webp" alt="Plano Anual" />
            <h2>Plano Anual</h2>
            <p class="preco">R$895,90</p>
            <div class="plan-button-container">
                <?php if ($plano_contratado): ?>
                    <div class="message-container">
                        <p>Você só pode contratar um plano por vez.</p>
                    </div>
                <?php else: ?>
                    <button onclick="window.location.href='checkout.php?plano=anual'">Escolher Plano</button>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        &copy; 2025 Estação do corpo. Todos os direitos reservados a (Lucas e Erick)
    </footer>

</body>
</html>