<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php';

// Verifica se os campos de e-mail e senha foram enviados
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para evitar injeção de SQL
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verifica a senha usando password_verify
        // IMPORTANTE: Sua senha no banco de dados precisa estar HASHED com password_hash()
        if (password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido!
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome']; // Opcional: para personalizar a experiência

            // Redireciona para uma página de membro
            header("Location: inicio.php"); // Crie esta página protegida!
            exit();
        } else {
            // Senha incorreta
            $_SESSION['login_erro'] = "E-mail ou senha inválidos.";
            header("Location: login.php");
            exit();
        }
    } else {
        // E-mail não encontrado
        $_SESSION['login_erro'] = "E-mail ou senha inválidos.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
} else {
    // Redireciona para o login se o formulário não foi enviado
    header("Location: login.php");
    exit();
}

$conn->close();
?>