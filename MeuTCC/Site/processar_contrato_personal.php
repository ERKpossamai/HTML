<?php
session_start();

// Inclui o arquivo de conexão com o banco de dados.
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

// 1. VERIFICAÇÃO: Impede que o usuário contrate mais de um personal.
// Usamos a chave primária da tabela contratos_personal (id_usuario) para garantir isso.
$sql_verificacao = "SELECT id_usuario FROM contratos_personal WHERE id_usuario = ?";
$stmt_verificacao = $conn->prepare($sql_verificacao);
$stmt_verificacao->bind_param("i", $id_usuario);
$stmt_verificacao->execute();
$tem_contrato = $stmt_verificacao->get_result()->num_rows > 0;
$stmt_verificacao->close();

if ($tem_contrato) {
    // Se o usuário já tem um contrato, redireciona com uma mensagem de erro.
    $_SESSION['erro_contrato'] = "Você já possui um personal trainer contratado.";
    header("Location: servicos.php");
    exit();
}

// 2. INSERÇÃO: Se não há contrato, insere o novo registro no banco de dados.
try {
    // Inicia uma transação para garantir que a operação seja atômica.
    $conn->begin_transaction();

    $sql_inserir = "INSERT INTO contratos_personal (id_usuario, id_personal, data_contratacao, status) VALUES (?, ?, NOW(), 'ativo')";
    $stmt_inserir = $conn->prepare($sql_inserir);
    $stmt_inserir->bind_param("ii", $id_usuario, $id_personal_contratado);
    $stmt_inserir->execute();
    $stmt_inserir->close();

    // Confirma a transação.
    $conn->commit();
    
    $_SESSION['sucesso_contrato'] = "Contratação realizada com sucesso!";
    header("Location: servicos.php");
    exit();

} catch (Exception $e) {
    // Em caso de erro, desfaz a transação.
    $conn->rollback();
    $_SESSION['erro_contrato'] = "Erro ao processar a contratação: " . $e->getMessage();
    header("Location: servicos.php");
    exit();
}

$conn->close();
?>