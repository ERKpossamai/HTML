<?php
session_start();

// Garante que o arquivo de conexão PDO seja incluído
include 'conexao.php';

$usuario_logado = isset($_SESSION['usuario_id']);
$id_usuario = $usuario_logado ? $_SESSION['usuario_id'] : null;

$tem_contrato = false;
$id_personal_contratado = null;
$mensagem_sucesso = '';
$mensagem_erro = '';

if ($usuario_logado) {
    // 1. Verifica se o usuário já tem um contrato e qual o ID do personal
    $sql_contrato_existente = "SELECT id_personal FROM contratos_personal WHERE id_usuario = ?";
    $stmt_contrato = $pdo->prepare($sql_contrato_existente);
    $stmt_contrato->execute([$id_usuario]);
    $dados_contrato = $stmt_contrato->fetch(PDO::FETCH_ASSOC);

    if ($dados_contrato) {
        $tem_contrato = true;
        $id_personal_contratado = $dados_contrato['id_personal'];
    }

    if (isset($_SESSION['sucesso_contrato'])) {
        $mensagem_sucesso = $_SESSION['sucesso_contrato'];
        unset($_SESSION['sucesso_contrato']);
    }
    if (isset($_SESSION['erro_contrato'])) {
        $mensagem_erro = $_SESSION['erro_contrato'];
        unset($_SESSION['erro_contrato']);
    }
}

$sql_personais = "SELECT id_personal, nome_personal, especialidade, bio, foto FROM personais";
$stmt_personais = $pdo->query($sql_personais);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - Estação do Corpo</title>
    <link rel="stylesheet" href="css/servicos.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="inicio.php">Estação do Corpo</a>
            </div>
            <ul class="nav-links">
                <li><a href="inicio.php">Início</a></li>
                <li><a href="planos.html">Planos</a></li>
                <li><a href="produto.html">Produtos</a></li>
                <li><a href="servicos.php" class="active">Serviços</a></li>
                <li><a href="local.html">Localização</a></li>
            </ul>
            <div class="nav-actions">
                <a href="carrinho.html" class="cart-icon">🛒<span class="cart-count">0</span></a>
            </div>
        </nav>
    </header>

    <main class="services-page">
        <section class="intro-section">
            <h1>Nossos Serviços</h1>
            <p>
                Na Estação do Corpo, oferecemos mais do que apenas um espaço para treinar. Proporcionamos uma experiência completa de transformação e superação. Com o acompanhamento dos melhores profissionais e equipamentos de ponta, estamos prontos para te ajudar a alcançar seus objetivos.
            </p>
        </section>

        <section class="personal-trainers-section">
            <h2>Personal Trainers de Elite</h2>
            <p>Nossa equipe é formada por profissionais qualificados e experientes, prontos para criar um plano de treino personalizado que atenda às suas necessidades e maximize seus resultados.</p>

            <?php if (!empty($mensagem_sucesso)): ?>
                <p class="mensagem-sucesso"><?php echo htmlspecialchars($mensagem_sucesso); ?></p>
            <?php endif; ?>
            <?php if (!empty($mensagem_erro)): ?>
                <p class="mensagem-erro"><?php echo htmlspecialchars($mensagem_erro); ?></p>
            <?php endif; ?>

            <div class="trainers-container">
                <?php
                if ($stmt_personais->rowCount() > 0) {
                    while ($personal = $stmt_personais->fetch(PDO::FETCH_ASSOC)) {
                        $caminho_foto = 'img/' . htmlspecialchars($personal['foto']);
                ?>
                        <div class="trainer-card">
                            <img src="<?php echo $caminho_foto; ?>" alt="Foto de <?php echo htmlspecialchars($personal['nome_personal']); ?>">
                            <div class="trainer-info">
                                <h3><?php echo htmlspecialchars($personal['nome_personal']); ?></h3>
                                <div class="trainer-details">
                                    <p><strong>Especialidade:</strong> <?php echo htmlspecialchars($personal['especialidade']); ?></p>
                                    <p><?php echo htmlspecialchars($personal['bio']); ?></p>
                                </div>
                                
                                <?php if ($usuario_logado && $tem_contrato): ?>
                                    <?php if ($personal['id_personal'] == $id_personal_contratado): ?>
                                        <button class="hire-button contratado" disabled>Já Contratado</button>
                                    <?php else: ?>
                                        <button class="hire-button desabilitado" disabled>Você só pode contratar um por vez</button>
                                    <?php endif; ?>
                                <?php elseif ($usuario_logado): ?>
                                    <a href="processar_contrato_personal.php?id=<?php echo $personal['id_personal']; ?>" class="hire-button">Contratar</a>
                                <?php else: ?>
                                    <a href="login.php" class="hire-button">Login para Contratar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>Nenhum personal trainer disponível no momento.</p>";
                }
                ?>
            </div>
        </section>

        <section class="equipment-section">
            <h2>Equipamentos de Alta Performance</h2>
            <p>Investimos em tecnologia de ponta para garantir que seu treino seja seguro, eficiente e motivador. Nossa academia está equipada com as melhores marcas do mercado.</p>
            <div class="equipment-gallery">
                <img src="img/ft1.png.jpg" alt="Equipamentos de musculação">
                <img src="img/ft2.png.jpg" alt="Área de cardio com esteiras">
                <img src="img/bora.jpg" alt="Halteres e pesos livres">
            </div>
        </section>
    </main>
</body>
</html>