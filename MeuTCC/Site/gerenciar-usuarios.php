<?php
session_start();

// Garanta que apenas administradores possam acessar esta página
// Você pode verificar um campo "is_admin" na sua tabela de usuários, por exemplo.
// if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
//     header("Location: inicio.php");
//     exit();
// }

include 'conexao.php';

// Consulta para buscar todos os usuários e suas datas de login/logout
$sql = "SELECT id, nome, email, ultimo_login, ultimo_logout FROM usuarios ORDER BY id DESC";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Painel Admin</title>
    <link rel="stylesheet" href="css/admin.css"> <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 1000px; margin: 50px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn-container { text-align: center; margin-top: 20px; }
        .btn-voltar { background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Gerenciar Acesso dos Usuários</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Último Login</th>
                    <th>Último Logout</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($usuarios): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo $usuario['ultimo_login'] ? htmlspecialchars(date('d/m/Y H:i:s', strtotime($usuario['ultimo_login']))) : 'N/A'; ?></td>
                            <td><?php echo $usuario['ultimo_logout'] ? htmlspecialchars(date('d/m/Y H:i:s', strtotime($usuario['ultimo_logout']))) : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum usuário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="btn-container">
            <a href="dashboard-admin.php" class="btn-voltar">Voltar para o Painel</a>
        </div>
    </div>

</body>
</html>