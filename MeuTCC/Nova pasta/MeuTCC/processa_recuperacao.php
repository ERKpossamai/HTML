<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // 1. Encontra o usuário pelo e-mail
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        // 2. Gera um token único e a data de expiração
        $token = bin2hex(random_bytes(32)); 
        $expiracao = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // 3. Salva o token e a data de expiração no banco de dados
        $stmt = $conn->prepare("UPDATE usuarios SET token_recuperacao = ?, token_expira = ? WHERE id = ?");
        $stmt->bind_param("ssi", $token, $expiracao, $user['id']);
        $stmt->execute();
        $stmt->close();

        // 4. Exibe o link na tela para testes (SOLUÇÃO TEMPORÁRIA)
        // **CORREÇÃO: Removi a parte '/seu-projeto/' para ser mais genérico**
        $link = "http://localhost/Site/MeuTcc/redefinir_senha.php?token=" . $token;

        echo "<h2>Link de Recuperação (Apenas para Testes)</h2>";
        echo "<p>Para redefinir a senha, clique no link abaixo:</p>";
        echo "<a href='" . htmlspecialchars($link) . "'>" . htmlspecialchars($link) . "</a>";
        echo "<br><br><p>Token gerado: " . $token . "</p>";

        exit();
        
    } else {
        // Para segurança, mostre uma mensagem genérica
        echo "Se o seu e-mail estiver em nosso sistema, um link seria enviado.";
    }
} else {
    header("Location: esqueci_a_senha.php");
}
$conn->close();
?>