<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do plano foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['plano_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $plano_id = $_POST['plano_id'];

    try {
        // Inicia uma transação para garantir que ambas as operações (verificar e deletar) sejam atômicas
        $pdo->beginTransaction();

        // 1. Busca os dados de cancelamento do usuário
        $sql_usuario = "SELECT cancelamentos_semana, ultima_data_cancelamento FROM usuarios WHERE id = :usuario_id";
        $stmt_usuario = $pdo->prepare($sql_usuario);
        $stmt_usuario->bindValue(':usuario_id', $usuario_id);
        $stmt_usuario->execute();
        $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

        $cancelamentos_semana = $usuario['cancelamentos_semana'];
        $ultima_data_cancelamento = $usuario['ultima_data_cancelamento'];

        // Define a data de uma semana atrás
        $data_uma_semana_atras = date('Y-m-d', strtotime('-7 days'));
        $data_atual = date('Y-m-d');

        // Reseta o contador se a última data de cancelamento for de mais de 7 dias atrás
        if ($ultima_data_cancelamento < $data_uma_semana_atras) {
            $cancelamentos_semana = 0;
        }

        // 2. Verifica se o limite de 3 cancelamentos por semana foi atingido
        if ($cancelamentos_semana >= 3) {
            $pdo->rollBack(); // Desfaz a transação
            // Redireciona com uma mensagem de erro
            header("Location: editar-plano.php?erro_cancelamento=limite_atingido");
            exit();
        }

        // 3. Deleta o plano do banco de dados
        $sql_delete = "DELETE FROM planos WHERE id = :plano_id AND usuario_id = :usuario_id";
        $stmt_delete = $pdo->prepare($sql_delete);
        $stmt_delete->bindValue(':plano_id', $plano_id);
        $stmt_delete->bindValue(':usuario_id', $usuario_id);
        
        if ($stmt_delete->execute()) {
            // 4. Atualiza o contador e a data de cancelamento na tabela de usuários
            $sql_update_usuario = "UPDATE usuarios SET cancelamentos_semana = cancelamentos_semana + 1, ultima_data_cancelamento = :data_atual WHERE id = :usuario_id";
            $stmt_update_usuario = $pdo->prepare($sql_update_usuario);
            $stmt_update_usuario->bindValue(':data_atual', $data_atual);
            $stmt_update_usuario->bindValue(':usuario_id', $usuario_id);
            $stmt_update_usuario->execute();

            // Confirma a transação
            $pdo->commit();

            // Sucesso: redireciona para a página de planos com uma mensagem de sucesso
            header("Location: planos.php?cancelado=true");
            exit();
        } else {
            // Erro ao deletar o plano
            $pdo->rollBack();
            echo "Erro ao cancelar o plano. Tente novamente.";
        }

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Erro no processamento: " . $e->getMessage();
    }
} else {
    // Se o acesso for direto ou sem o ID do plano, redireciona de volta
    header("Location: editar-plano.php");
    exit();
}
?>