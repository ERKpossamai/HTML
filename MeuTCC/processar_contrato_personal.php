<?php
session_start();

// Inclui o arquivo de conexão com o banco de dados.
// Ele deve criar a variável $pdo.
include 'conexao.php';

// Redireciona para a página de login se o usuário não estiver logado.
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['erro_contrato'] = "Você precisa estar logado para contratar um personal trainer.";
    header("Location: login.php");
    exit();
}

// Verifica se o ID do personal foi passado via URL e se é um número válido.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['erro_contrato'] = "ID do personal trainer inválido.";
    header("Location: servicos.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$id_personal_contratado = $_GET['id'];

try {
    // 1. VERIFICAÇÃO: Impede que o usuário contrate mais de um personal.
    $sql_verificacao = "SELECT id_usuario FROM contratos_personal WHERE id_usuario = ?";
    $stmt_verificacao = $pdo->prepare($sql_verificacao);
    $stmt_verificacao->execute([$id_usuario]);
    $tem_contrato = $stmt_verificacao->fetch();

    if ($tem_contrato) {
        // Se o usuário já tem um contrato, redireciona com uma mensagem de erro.
        $_SESSION['erro_contrato'] = "Você já possui um personal trainer contratado.";
        header("Location: servicos.php");
        exit();
    }

    // 2. INSERÇÃO: Se não há contrato, insere o novo registro.
    // Inicia uma transação para garantir que a operação seja atômica.
    $pdo->beginTransaction();

    $sql_inserir = "INSERT INTO contratos_personal (id_usuario, id_personal, data_contratacao, status) VALUES (?, ?, NOW(), 'ativo')";
    $stmt_inserir = $pdo->prepare($sql_inserir);
    $stmt_inserir->execute([$id_usuario, $id_personal_contratado]);

    // Confirma a transação.
    $pdo->commit();
    
    $_SESSION['sucesso_contrato'] = "Contratação realizada com sucesso!";
    header("Location: servicos.php");
    exit();

} catch (PDOException $e) {
    // Em caso de erro, desfaz a transação.
    $pdo->rollBack();
    $_SESSION['erro_contrato'] = "Erro ao processar a contratação: " . $e->getMessage();
    header("Location: servicos.php");
    exit();
}
// Com PDO, não é necessário fechar a conexão manualmente.
?>