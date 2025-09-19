<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Estação do Corpo</title>
    <link rel="stylesheet" href="css/esquecia_senha.css">
</head>
<body>

    <div class="container">
        <h2>Recuperar Senha</h2>
        <p>Digite seu e-mail para receber um link de recuperação.</p>
        
        <?php if (isset($_GET['mensagem'])): ?>
            <div style="color: green; text-align: center; margin-bottom: 15px;">
                <?php echo htmlspecialchars($_GET['mensagem']); ?>
            </div>
        <?php endif; ?>

        <form action="processa_recuperacao.php" method="POST">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Enviar Link</button>
        </form>
    </div>

</body>
</html>