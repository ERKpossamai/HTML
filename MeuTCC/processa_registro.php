<?php
session_start();
include 'conexao.php'; // Aqui já temos $pdo

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificação de campos
    if (empty($nome) || empty($email) || empty(trim($senha))) {
        $_SESSION['registro_erro'] = "Todos os campos são obrigatórios.";
        header("Location: registrar.php");
        exit();
    }

    // Cria o hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch();

    if ($result) {
        $_SESSION['registro_erro'] = "Este e-mail já está cadastrado.";
        header("Location: registrar.php");
        exit();
    }

    // Define plano padrão
    $plano_padrao = "Plano Básico";

    // Insere novo usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, plano, data_matricula) 
                           VALUES (?, ?, ?, ?, CURDATE())");

    if ($stmt->execute([$nome, $email, $senha_hash, $plano_padrao])) {
        $_SESSION['registro_sucesso'] = "Conta criada com sucesso! Faça login para continuar.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['registro_erro'] = "Erro ao criar a conta. Tente novamente.";
        header("Location: registrar.php");
        exit();
    }
} else {
    header("Location: registrar.php");
    exit();
}
?>
