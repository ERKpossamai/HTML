<?php
// Inicia a sessão para acessar as informações do usuário logado
session_start();

// Verifica se o usuário não está logado OU se ele não é um administrador.
// A lógica '!' (não) garante que a condição seja verdadeira caso a sessão não exista ou 'is_admin' seja falso.
if (!isset($_SESSION['usuario_logado']) || $_SESSION['is_admin'] !== 1) {
    // Se a verificação falhar, redireciona para a página de login
    // e sai do script para prevenir qualquer execução de código adicional.
    header('Location: login.php?acesso_negado=true');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
</head>
<body>
    <header>
        <div class="logo-container">
            <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo" />
            <h1>Estação do Corpo - Painel de Admin</h1>
        </div>
        <nav class="nav-admin">
            <a href="cadastrar-personal.php">Cadastrar Personal</a>
            <a href="gerenciar-usuarios.php">Gerenciar Usuários</a>
            <a href="logout.php" class="btn-logout">Sair</a>
        </nav>
    </header>

    <main class="content">
        <h2>Bem-vindo, Administrador!</h2>
        <p>Utilize o menu acima para gerenciar o seu site. Aqui você pode:</p>
        <ul>
            <li>Cadastrar novos personal trainers.</li>
            <li>Visualizar e editar a lista de usuários.</li>
            <li>Acessar relatórios e estatísticas.</li>
        </ul>
    </main>
</body>
</html>
