<?php
// conexao.php
$servidor = "localhost";    // Geralmente 'localhost'
$usuario_db = "root";       // Usuário do seu banco de dados (ex: 'root')
$senha_db = "";             // Senha do seu banco de dados
$banco = "estacao";     // Nome do seu banco de dados

// Cria a conexão
$conn = new mysqli($servidor, $usuario_db, $senha_db, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Define o charset para utf8 para evitar problemas com acentos
$conn->set_charset("utf8");
?>