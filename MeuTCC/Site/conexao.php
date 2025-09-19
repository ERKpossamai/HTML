<?php
// conexao.php
$servidor = "localhost";    // Geralmente 'localhost'
$usuario_db = "root";       // Usuário do seu banco de dados (ex: 'root')
$senha_db = "";             // Senha do seu banco de dados
$banco = "estacao";         // Nome do seu banco de dados

try {
    // Cria conexão PDO
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario_db, $senha_db);
    
    // Define o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Falha na conexão: " . $e->getMessage());
}
?>
