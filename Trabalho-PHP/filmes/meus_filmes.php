<?php
session_start();
require '../includes/conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta os filmes cadastrados pelo usuário
$sql = "SELECT * FROM filmes WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Filmes</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class="formulario-container">
        <h1>Filmes Cadastrados</h1>

        <?php if ($result->num_rows > 0): ?>
            <ul style="list-style: none; padding: 0;">
                <?php while($row = $result->fetch_assoc()): ?>
                    <li style="margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px;">
                        <strong><?= htmlspecialchars($row['nome']) ?></strong><br>
                        Diretor: <?= htmlspecialchars($row['diretor']) ?><br>
                        Valor: R$ <?= number_format($row['valor'], 2, ',', '.') ?><br>
                        Estoque: <?= htmlspecialchars($row['estoque']) ?><br><br>
                        <a href="editar_filme.php?id=<?= $row['id'] ?>">✏️ Editar</a> |
                        <a href="excluir_filme.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este filme?')">🗑️ Excluir</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhum filme cadastrado.</p>
        <?php endif; ?>

        <!-- Ações extras -->
        <div class="botoes" style="margin-top: 30px;">
            <a href="formulario_filme.php">➕ Cadastrar Novo Filme</a>
            <a href="autenticacao/logout.php">🚪 Sair</a>
            <a href="index.php">🔙 Voltar à Página Inicial</a>
        </div>
    </div>
</body>
</html>
