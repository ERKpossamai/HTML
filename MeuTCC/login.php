<?php
session_start();

// Inclui o arquivo de conexão com o banco de dados.
// Ele deve criar a variável $pdo.
include 'conexao.php';

$erro = '';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // --- 1. VERIFICAÇÃO DE BLOQUEIO ---
    $stmt_bloqueio = $pdo->prepare("SELECT bloqueado_ate FROM tentativas_login WHERE email = ?");
    $stmt_bloqueio->execute([$email]);
    $bloqueio = $stmt_bloqueio->fetch(PDO::FETCH_ASSOC);

    if ($bloqueio && strtotime($bloqueio['bloqueado_ate']) > time()) {
        $erro = "Excedidas as tentativas, tente novamente em 1 minuto.";
    } else {
        // --- 2. PROCESSO DE LOGIN NORMAL ---
        $stmt = $pdo->prepare("SELECT id, nome, senha, is_admin FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['is_admin'] = $usuario['is_admin'];

            // Reseta as tentativas de login após o sucesso
            $stmt_reset = $pdo->prepare("DELETE FROM tentativas_login WHERE email = ?");
            $stmt_reset->execute([$email]);

            // Redireciona com base na permissão
            if ($usuario['is_admin'] == 1) { 
                header("Location: dashboard-admin.php");
            } else {
                header("Location: inicio.php");
            }
            exit();
        } else {
            // Login falhou: registra a tentativa
            $erro = "E-mail ou senha incorretos.";
            
            // Incrementa o contador de tentativas
            $stmt_count = $pdo->prepare("SELECT tentativas FROM tentativas_login WHERE email = ?");
            $stmt_count->execute([$email]);
            $tentativas_atuais = $stmt_count->fetchColumn();

            if ($tentativas_atuais === false) {
                // Primeira tentativa de erro: insere um novo registro
                $stmt_insert = $pdo->prepare("INSERT INTO tentativas_login (email, tentativas, hora_ultima_tentativa) VALUES (?, 1, NOW())");
                $stmt_insert->execute([$email]);
            } else {
                $novas_tentativas = $tentativas_atuais + 1;
                $bloqueado_ate = null;
                if ($novas_tentativas >= 3) {
                    $bloqueado_ate = date('Y-m-d H:i:s', strtotime('+1 minute'));
                }
                
                // Atualiza o registro de tentativas
                $stmt_update = $pdo->prepare("UPDATE tentativas_login SET tentativas = ?, hora_ultima_tentativa = NOW(), bloqueado_ate = ? WHERE email = ?");
                $stmt_update->execute([$novas_tentativas, $bloqueado_ate, $email]);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css" />
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
</head>

<body>
    <header>
        <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo" />
        <h1>Estação do corpo</h1>

        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <div class="wrapper">
        <div class="form-box login">
            <h2>Login</h2>
            <?php if (!empty($erro)) { echo "<p class='error-message'>$erro</p>"; } ?>
            <form action="login.php" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" id="email-login" name="email" required />
                    <label for="email-login">Email</label>
                </div>
                
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" id="senha-login" name="senha" required />
                    <label for="senha-login">Senha</label>
                </div>
                <div class="remember-forgot">
                    <label for="lembrar-login">
                        <input type="checkbox" id="lembrar-login" /> Lembrar de mim
                    </label>
                    <a href="esqueci_a_senha.php">Esqueceu sua senha?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>Não tem uma conta? <a href="#" class="register-link">Registrar</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registrar</h2>
            <form action="processa_registro.php" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" id="nome" name="nome" required />
                    <label for="nome">Nome de Usuário</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" id="email" name="email" required />
                    <label for="email">Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" id="senha" name="senha" required />
                    <label for="senha">Senha</label>
                </div>
                <div class="remember-forgot">
                    <label for="aceite">
                        <input type="checkbox" id="aceite" required /> Eu li e aceito os termos
                    </label>
                </div>
                <button type="submit" class="btn">Registrar</button>
                <div class="login-register">
                    <p>Já tem uma conta? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="js/script.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js" defer></script>
</body>

</html>