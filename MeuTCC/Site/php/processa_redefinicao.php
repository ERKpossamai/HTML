<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha']) && isset($_POST['token'])) {
    $senha = $_POST['senha'];
    $token = $_POST['token'];

    // 1. Verifica se o token é válido e não expirou
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE token_recuperacao = ? AND token_expira > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        // 2. Atualiza a senha e anula o token
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuarios SET senha = ?, token_recuperacao = NULL, token_expira = NULL WHERE id = ?");
        $stmt->bind_param("si", $senha_hash, $user['id']);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['login_sucesso'] = "Sua senha foi redefinida com sucesso. Faça login.";
        header("Location: login.php");
        exit();

    } else {
        // Se o token for inválido
        header("Location: redefinir_senha.php?erro=" . urlencode("Token inválido ou expirado."));
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
$conn->close();
?>