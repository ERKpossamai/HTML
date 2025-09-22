<?php
session_start();
include 'conexao.php'; // Inclui a conexão PDO

// Redireciona se não for um administrador
if (!isset($_SESSION['usuario_logado']) || $_SESSION['is_admin'] !== 1) {
    header('Location: login.php?acesso_negado=true');
    exit();
}

$erro = '';
$sucesso = '';

// LÓGICA PARA PROCESSAR A ATUALIZAÇÃO DO USUÁRIO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    
    // Validação básica
    if (empty($nome) || empty($email)) {
        $erro = "Nome e e-mail não podem ficar vazios.";
    } else {
        try {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, is_admin = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $is_admin, $id]);
            $sucesso = "Usuário atualizado com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao atualizar o usuário: " . $e->getMessage();
        }
    }
}

// LÓGICA PARA EXIBIR A LISTA OU O FORMULÁRIO DE EDIÇÃO
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Modo de Edição: Busca o usuário pelo ID
    $id_usuario = $_GET['id'];
    $usuario_para_editar = null;
    try {
        $sql = "SELECT id, nome, email, is_admin FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario]);
        $usuario_para_editar = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario_para_editar) {
            $erro = "Usuário não encontrado.";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao buscar usuário: " . $e->getMessage();
    }
} else {
    // Modo de Visualização: Busca todos os usuários
    $usuarios = [];
    try {
        $sql = "SELECT id, nome, email, is_admin FROM usuarios ORDER BY id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $erro = "Erro ao buscar a lista de usuários: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img class="logo-img" src="img/logo.png" alt="Logo Estação do Corpo" />
            <h1>Gerenciar Usuários</h1>
        </div>
        <nav class="nav-admin">
            <a href="dashboard-admin.php">Painel</a>
            <a href="cadastrar-personal.php">Cadastrar Personal</a>
            <a href="logout.php" class="btn-logout">Sair</a>
        </nav>
    </header>

    <main class="content">
        <?php if (!empty($erro)): ?>
            <p class="error-message"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>
        <?php if (!empty($sucesso)): ?>
            <p class="success-message"><?php echo htmlspecialchars($sucesso); ?></p>
        <?php endif; ?>

        <?php if (isset($usuario_para_editar) && $usuario_para_editar): ?>
            <h2>Editar Usuário: <?php echo htmlspecialchars($usuario_para_editar['nome']); ?></h2>
            <form action="editar-usuarios.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario_para_editar['id']); ?>">
                
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario_para_editar['nome']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario_para_editar['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <input type="checkbox" id="is_admin" name="is_admin" <?php echo $usuario_para_editar['is_admin'] == 1 ? 'checked' : ''; ?>>
                    <label for="is_admin">É Administrador</label>
                </div>
                
                <button type="submit" name="salvar">Salvar Alterações</button>
                <a href="editar-usuarios.php">Cancelar e Voltar</a>
            </form>

        <?php else: ?>
            <h2>Lista de Usuários</h2>
            <?php if (empty($usuarios)): ?>
                <p>Nenhum usuário encontrado.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo $usuario['is_admin'] == 1 ? 'Admin' : 'Comum'; ?></td>
                            <td>
                                <a href="editar-usuarios.php?id=<?php echo $usuario['id']; ?>">Editar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>
</html>