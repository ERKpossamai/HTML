<?php
$host = "localhost";
$user = "root";
$pass = "";
$bd = "meutcc";

$conn = new mysqli(hostname: $host, username: $user, password: $pass, database: $bd);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>