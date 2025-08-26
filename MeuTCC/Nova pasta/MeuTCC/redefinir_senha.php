<?php
include 'conexao.php';

$token = $_GET['token'] ?? '';
$erro = '';

if (empty($token)) {
    $erro = "Token de recuperação inválido.";
} else {
    $stmt = $conn->prepare("SELECT id, token_expira FROM usuarios WHERE token_recuperacao = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || strtotime($user['token_expira']) < time()) {
        $erro = "O link de recuperação é inválido ou já expirou.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Estação do Corpo</title>
    <link rel="stylesheet" href="css/esquecia_senha.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
</head>
<body>

    <div class="container">
        <h2>Redefinir Senha</h2>
        
        <?php if ($erro): ?>
            <p style="color: red; text-align: center;"><?php echo htmlspecialchars($erro); ?></p>
            <a href="esqueci_a_senha.php">Tente novamente</a>
        <?php else: ?>
            <p>Digite sua nova senha.</p>
            <form action="processa_redefinicao.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <label for="senha">Nova Senha:</label>
                <input type="password" id="senha" name="senha" required>
                <button type="submit">Redefinir Senha</button>
            </form>
            <a href="login.php" class="back-link">Voltar para o Login</a>
        <?php endif; ?>
    </div>


</body>
</html>