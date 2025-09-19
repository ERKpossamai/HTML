<?php
session_start();

// Verifica se o usuário está logado e se o ID de sessão existe.
// Isso é importante para evitar erros caso o script seja acessado sem um login ativo.
if (isset($_SESSION['usuario_id'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include 'conexao.php';

    try {
        // Prepara a consulta para atualizar o último_logout do usuário
        $sql = "UPDATE usuarios SET ultimo_logout = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        // Executa a consulta, passando o ID do usuário logado
        $stmt->execute([$_SESSION['usuario_id']]);
    } catch (PDOException $e) {
        // Opcional: Para fins de depuração, você pode registrar o erro.
        // Em um ambiente de produção, é melhor não exibir o erro ao usuário.
        // die("Erro ao registrar o logout: " . $e->getMessage());
    }
}

// Destrói todas as variáveis de sessão
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login ou página inicial
header("Location: index.php");
exit();
?>