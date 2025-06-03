<?php
include  'conexao.php';

$result = $conn->query("SELECT * FROM produtos");
$produtos = [];

while ($row = $result->fetch_assoc()) {
    $produtos[] = $row;
}

echo json_encode(value: $produtos);
?>