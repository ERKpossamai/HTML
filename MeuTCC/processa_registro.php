<?php
session_start();
include 'conexao.php';

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty(trim($senha))) {
        $_SESSION['registro_erro'] = "Todos os campos são obrigatórios.";
        header("Location: registrar.php");
        exit();
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['registro_erro'] = "Este e-mail já está cadastrado.";
        header("Location: registrar.php");
        exit();
    }

    $stmt->close();

    // PARTE ATUALIZADA:
    // 1. A instrução SQL agora inclui 'plano' e 'data_matricula'
    // 2. Os valores correspondentes são adicionados abaixo
    $plano_padrao = "Plano Básico";
    
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, plano, data_matricula) VALUES (?, ?, ?, ?, CURDATE())");
    $stmt->bind_param("ssss", $nome, $email, $senha_hash, $plano_padrao);

    if ($stmt->execute()) {
        $_SESSION['registro_sucesso'] = "Conta criada com sucesso! Faça login para continuar.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['registro_erro'] = "Erro ao criar a conta. Tente novamente.";
        header("Location: registrar.php");
        exit();
    }

    $stmt->close();
} else {
    header("Location: registrar.php");
    exit();
}
$conn->close();
?>