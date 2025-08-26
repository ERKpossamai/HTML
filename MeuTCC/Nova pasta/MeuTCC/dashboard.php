<?php
// Inicia a sessão
session_start();

// Verifica se o usuário NÃO está logado. Se não estiver, redireciona.
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: login.php");
    exit();
}

// O código abaixo só é executado se o usuário estiver logado
$nome_usuario = $_SESSION['usuario_nome'] ?? 'Usuário'; // Usa o nome da sessão, se existir
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário - Estação do Corpo</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<header>
    </header>

<div class="content">
    <h2>Bem-vindo, <?php echo htmlspecialchars($nome_usuario); ?>!</h2>
    <p>Este é o seu painel de controle. Você só está vendo esta página porque fez login com sucesso.</p>
    
    <p><a href="logout.php">Sair</a></p>
</div>

<footer>
    </footer>

</body>
</html>