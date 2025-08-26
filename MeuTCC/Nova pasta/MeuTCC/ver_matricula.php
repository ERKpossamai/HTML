<?php
// Inicia a sessão
session_start();

// Verifica se o usuário NÃO está logado. Se não, redireciona para a página de login.
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: login.php");
    exit();
}

// O código abaixo só será executado se o usuário estiver logado.
include 'conexao.php'; // Inclui o arquivo de conexão PDO, que define a variável $pdo

// Pega o ID do usuário da sessão
$usuario_id = $_SESSION['usuario_id'];

// --- 1. Consulta para os detalhes da matrícula do usuário ---
// Usando PDO:
try {
    $stmt = $pdo->prepare("SELECT nome, email, data_matricula FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário foi encontrado
    if (!$usuario) {
        // Redireciona para o dashboard ou exibe uma mensagem de erro
        header("Location: dashboard.php");
        exit();
    }

    // --- 2. Consulta para o personal trainer contratado ---
    $nome_personal = "Nenhum personal contratado"; // Valor padrão

    $sql_personal = "SELECT p.nome_personal
                     FROM contratos_personal cp
                     JOIN personais p ON cp.id_personal = p.id_personal
                     WHERE cp.id_usuario = ?";

    $stmt_personal = $pdo->prepare($sql_personal);
    $stmt_personal->execute([$usuario_id]);
    $resultado_personal = $stmt_personal->fetch(PDO::FETCH_ASSOC);

    if ($resultado_personal) {
        $nome_personal = htmlspecialchars($resultado_personal['nome_personal']);
    }

} catch (PDOException $e) {
    die("Erro na consulta ao banco de dados: " . $e->getMessage());
}

// Não é necessário fechar a conexão ($pdo->close()) pois o PDO a gerencia automaticamente.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Matrícula - Estação do Corpo</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
    
    <style>
        .container {
            max-width: 800px;
            margin: 150px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .data-item {
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        .data-item strong {
            display: inline-block;
            width: 150px; /* Alinha os títulos */
        }
    </style>
</head>
<body>

    <header>
        <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo">
        <h1>Estação do corpo</h1>
        <nav class="navegation">
            <ul>
                <li><a href="inicio.php">Início</a></li>
                <li><a href="planos.php">Planos</a></li>
                <li><a href="produto.php">Produtos</a></li>
                <li><a href="local.html">Localização</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Detalhes da Matrícula</h2>
        <div class="data-item">
            <strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?>
        </div>
        <div class="data-item">
            <strong>E-mail:</strong> <?php echo htmlspecialchars($usuario['email']); ?>
        </div>
        <div class="data-item">
            <strong>Data da Matrícula:</strong> <?php echo htmlspecialchars($usuario['data_matricula']); ?>
        </div>
        <div class="data-item">
            <strong>Personal Trainer:</strong> <?php echo $nome_personal; ?>
        </div>
    </div>
    
    <footer>
        &copy; 2025 Estação do corpo. Todos os direitos reservados.
    </footer>

</body>
</html>