<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('content-type: application/json');

include('conexao.php');

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
    exit;
}

$nome = $data['nome'] ?? '';
$endereco = $data['endereco'] ?? '';
$cep = $data['cep'] ?? '';
$carrinho = $data['carrinho'] ?? [];
$total = $data['total'] ?? 0;
$frete = $data['frete'] ?? 0;

if (empty($nome) || empty($endereco) || empty($cep) || empty($carrinho)) {
    echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
    exit;
}

// salvar clientes
$stmt = $conn->prepare("INSERT INTO clientes (nome, endereco, cep) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $endereco, $cep);
$stmt->execute();
$cliente_id = $stmt->insert_id;
$stmt->close();

// salvar pedido
$stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, total, frete) VALUES (?, ?, ?)");
$stmt->bind_param("idd", $cliente_id, $total, $frete);
$stmt->execute();
$pedido_id = $stmt->insert_id;


?>