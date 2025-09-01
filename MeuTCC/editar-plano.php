<?php
session_start();
include 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

// 1. Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$plano = null;

// 2. Busca os detalhes do plano do usuário no banco de dados
try {
    $sql = "SELECT * FROM planos WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':usuario_id', $usuario_id);
    $stmt->execute();
    $plano = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Em caso de erro, apenas defina o plano como nulo para exibir a mensagem de erro na página
    $plano = null;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Plano - Estação do Corpo</title>
    <link rel="stylesheet" href="css/planos.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
    <style>
        body {
            font-family: sans-serif;
            background-color: #0d0d0d;
            color: #e0e0e0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background-color: #1a1a1a;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .container h1 {
            color: #ffd700;
            margin-bottom: 20px;
        }
        .details-box {
            background-color: #2a2a2a;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .details-box p {
            font-size: 1.1em;
            margin: 10px 0;
            border-bottom: 1px solid #444;
            padding-bottom: 10px;
        }
        .details-box p:last-child {
            border-bottom: none;
        }
        .message-error {
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-action {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1em;
            font-weight: bold;
            color: #fff;
            background-color: #f44336;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-action:hover {
            background-color: #d32f2f;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Gerenciar seu Plano</h1>

    <?php
    // Exibe a mensagem de erro se o limite de cancelamento foi atingido
    if (isset($_GET['erro_cancelamento']) && $_GET['erro_cancelamento'] == 'limite_atingido'): ?>
        <div class="message-error">
            <p><strong>Atenção:</strong> Você já atingiu o limite de 3 cancelamentos por semana.</p>
            <p>Tente novamente na próxima semana.</p>
        </div>
    <?php endif; ?>

    <?php if ($plano): ?>
        <div class="details-box">
            <h2>Seu Plano Atual: <?php echo htmlspecialchars(ucfirst($plano['plano'])); ?></h2>
            <p><strong>Valor:</strong> R$<?php echo number_format($plano['preco'], 2, ',', '.'); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($plano['status'])); ?></p>
            <p><strong>Contratado em:</strong> <?php echo date('d/m/Y', strtotime($plano['criado_em'])); ?></p>
        </div>
        
        <p>Para cancelar sua assinatura, clique no botão abaixo.</p>
        <form action="cancelar-plano.php" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar seu plano? Essa ação é irreversível.');">
            <input type="hidden" name="plano_id" value="<?php echo htmlspecialchars($plano['id']); ?>">
            <button type="submit" class="btn-action">Cancelar Plano</button>
        </form>

    <?php else: ?>
        <div class="details-box">
            <p>Você não possui nenhum plano contratado no momento.</p>
        </div>
    <?php endif; ?>

    <a href="planos.php" class="back-link">Voltar para a página de Planos</a>

</div>

</body>
</html>