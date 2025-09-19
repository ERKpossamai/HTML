<?php
session_start();

// Apenas admins podem acessar
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header('Location: login.php?acesso_negado=true');
    exit();
}

// Lógica de processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conexao.php';

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $especialidade = $_POST['especialidade'];
    $bio = $_POST['bio'];

    // Upload da foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $pasta = "uploads/personais/";
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeArquivo = uniqid() . "_" . basename($_FILES['foto']['name']);
        $caminhoArquivo = $pasta . $nomeArquivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoArquivo)) {
            $foto = $caminhoArquivo;
        }
    }

    try {
$stmt = $pdo->prepare("INSERT INTO personais (nome_personal, especialidade, bio, foto) 
                       VALUES (?, ?, ?, ?)");
$stmt->execute([$nome, $especialidade, $bio, $foto]);


        header('Location: dashboard-admin.php?sucesso=personal_cadastrado');
        exit();
    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar personal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Personal</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo" />
            <h1>Estação do Corpo - Cadastro de Personal</h1>
        </div>
        <nav class="nav-admin">
            <a href="dashboard-admin.php">Voltar para o Painel</a>
            <a href="logout.php" class="btn-logout">Sair</a>
        </nav>
    </header>

    <main class="content">
        <h2>Cadastrar Novo Personal</h2>

        <?php if (isset($erro)) { echo "<p style='color: red;'>$erro</p>"; } ?>

        <form action="cadastrar-personal.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
    
            <div class="form-group">
                <label for="especialidade">Especialidade:</label>
                <input type="text" id="especialidade" name="especialidade" required>
            </div>
            <div class="form-group">
                <label for="bio">Biografia:</label>
                <textarea id="bio" name="bio" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <button type="submit" class="btn-submit">Cadastrar Personal</button>
        </form>
    </main>
</body>
</html>
