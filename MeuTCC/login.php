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

        <!-- Botão do menu hambúrguer -->
        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </header>

    <div class="wrapper">
        <!-- FORMULÁRIO DE LOGIN -->
        <div class="form-box login">
            <h2>Login</h2>
            <form action="processa_login.php" method="POST">
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

        <!-- FORMULÁRIO DE REGISTRO -->
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

    <!-- Carrinho detalhado -->
    <div class="oculto">
        <div id="carrinho-detalhes" class="oculto">
            <ul id="lista-carrinho"></ul>
            <p><strong>Total:</strong> R$ <span id="total">0.00</span></p>
            <button onclick="finalizarCompra()" class="finalizar">Finalizar Compra</button>
        </div>
    </div>

    <script src="js/script.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js" defer></script>
</body>

</html>
