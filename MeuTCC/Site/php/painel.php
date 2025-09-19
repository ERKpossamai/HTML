<?php
session_start();

// Verifica se o usuário está logado. Se não, redireciona para a página de login.
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário</title>
    <style> body { font-family: Arial, sans-serif; padding: 20px; } </style>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
    <p>Este é o seu painel. Somente usuários logados podem ver esta página.</p>
    
    <nav>
        <a href="inicio.php">Voltar para o Início</a> |
        <a href="sair.php">Sair</a>
    </nav>
</body>
</html>