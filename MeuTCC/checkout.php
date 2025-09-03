<?php
// Inicia a sessão para que o código não gere erros futuros.
session_start();

// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php';

// 1. Recebe o nome do plano selecionado pela URL (usando '?plano=')
$plano = $_GET['plano'] ?? 'desconhecido';

// Define o preço com base no plano
$preco = 0;
switch ($plano) {
    case 'mensal':
        $preco = 119.90;
        break;
    case 'semestral':
        $preco = 595.90;
        break;
    case 'anual':
        $preco = 895.90;
        break;
    default:
        // Caso o plano seja inválido, exibe uma mensagem de erro e para a execução
        echo '
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erro no Pedido</title>
            <style>
                body {
                    font-family: sans-serif;
                    background-color: #0d0d0d;
                    color: #e0e0e0;
                    margin: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .error-container {
                    text-align: center;
                    background-color: #1a1a1a;
                    padding: 50px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
                    border: 1px solid #ff4d4d;
                }
                .error-container h1 {
                    color: #ff4d4d;
                    font-size: 2.5em;
                }
                .error-container p {
                    font-size: 1.2em;
                    margin: 10px 0;
                }
            </style>
        </head>
        <body>
            <div class="error-container">
                <h1>Erro!</h1>
                <p>Plano inválido. Por favor, volte e selecione um plano válido.</p>
            </div>
        </body>
        </html>
        ';
        exit;
}

// 2. Processa os dados do formulário quando ele for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // **PULANDO A VERIFICAÇÃO DE LOGIN (Lembre-se de mudar isso depois!)**
    $usuario_id = 1;

    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $plano_escolhido = $_POST['plano'];
    $preco_final = $preco;

    // SQL para inserir os dados no banco de dados
    $sql_pedido = "INSERT INTO pedidos (usuario_id, nome, telefone, cpf, plano, preco) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("issssd", $usuario_id, $nome, $telefone, $cpf, $plano_escolhido, $preco_final);

    // Se o pedido for salvo com sucesso
    if ($stmt_pedido->execute()) {
        // Gera a página de sucesso com estilo e o botão para voltar ao início
        echo '
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Pedido Realizado</title>
            <style>
                body {
                    font-family: sans-serif;
                    background-color: #0d0d0d;
                    color: #e0e0e0;
                    margin: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .success-container {
                    text-align: center;
                    background-color: #1a1a1a;
                    padding: 50px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
                }
                .success-container h1 {
                    color: #4CAF50;
                    font-size: 2.5em;
                }
                .success-container p {
                    font-size: 1.2em;
                    margin: 10px 0;
                }
                .success-container strong {
                    color: #ffd700;
                }
                .btn-home {
                    display: inline-block;
                    background-color: #4CAF50;
                    color: white;
                    padding: 15px 30px;
                    text-decoration: none;
                    border-radius: 5px;
                    margin-top: 20px;
                    transition: background-color 0.3s;
                }
                .btn-home:hover {
                    background-color: #45a049;
                }
            </style>
        </head>
        <body>
            <div class="success-container">
                <h1>Pedido Realizado com Sucesso!</h1>
                <p>Obrigado, <strong>' . $nome . '</strong>! Seu pedido do plano <strong>' . ucfirst($plano_escolhido) . '</strong> foi processado.</p>
                <p>Entraremos em contato pelo telefone <strong>' . $telefone . '</strong> para finalizar o pagamento.</p>
                <a href="inicio.php" class="btn-home">Voltar ao Início</a>
            </div>
        </body>
        </html>
        ';
    } else {
        // Gera a página de erro com estilo
        echo '
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erro no Pedido</title>
            <style>
                body {
                    font-family: sans-serif;
                    background-color: #0d0d0d;
                    color: #e0e0e0;
                    margin: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .error-container {
                    text-align: center;
                    background-color: #1a1a1a;
                    padding: 50px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
                    border: 1px solid #ff4d4d;
                }
                .error-container h1 {
                    color: #ff4d4d;
                    font-size: 2.5em;
                }
                .error-container p {
                    font-size: 1.2em;
                    margin: 10px 0;
                }
            </style>
        </head>
        <body>
            <div class="error-container">
                <h1>Erro!</h1>
                <p>Ocorreu um erro ao processar seu pedido.</p>
                <p>Detalhes do erro: ' . $stmt_pedido->error . '</p>
            </div>
        </body>
        </html>
        ';
    }
    
    $stmt_pedido->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Estação do Corpo</title>
    
    <style>
        body {
            font-family: sans-serif;
            background-color: #0d0d0d;
            color: #e0e0e0;
            margin: 0;
            display: grid;
            place-items: center;
            min-height: 100vh;
        }

        .checkout-container {
            width: 90%;
            max-width: 500px;
            background-color: #1a1a1a;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #ffd700;
            text-align: center;
            margin-bottom: 5px;
        }
        p {
            font-size: 1.2em;
            color: #4CAF50;
            text-align: center;
            margin-top: 0;
            margin-bottom: 30px;
        }
        form {
            width: 100%;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #0d0d0d;
            color: #e0e0e0;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            text-transform: uppercase;
            transition: background-color 0.3s;
            margin-bottom: 10px; /* Adicionado para separar o botão de Cancelar */
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .btn-cancelar {
            display: block;
            text-align: center;
            background-color: #555;
            color: white;
            padding: 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }
        .btn-cancelar:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h1>Finalizar Compra - Plano <?php echo ucfirst($plano); ?></h1>
        <p>Preço: R$ <?php echo number_format($preco, 2, ',', '.'); ?></p>

        <form action="checkout.php?plano=<?php echo $plano; ?>" method="POST">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>

            <input type="hidden" name="plano" value="<?php echo $plano; ?>">

            <input type="submit" value="Enviar Pedido">
            
            <a href="planos.php" class="btn-cancelar">Cancelar</a>
        </form>
    </div>
</body>
</html>