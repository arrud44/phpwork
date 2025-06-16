<?php
session_start();

// Redireciona se o usuário não estiver autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/conexao.php'; // Importa conexão com o banco

$usuario_id = $_SESSION['usuario_id'];

// Consulta os filmes associados ao usuário logado
$sql = "SELECT * FROM filmes WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$filmes = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Filmes</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="formulario-container">
        <h1>Meus Filmes</h1>

        <!-- Exibe mensagens de sucesso ou erro -->
        <?php
        if (isset($_SESSION['sucesso'])) {
            echo "<p class='mensagem-sucesso'>{$_SESSION['sucesso']}</p>";
            unset($_SESSION['sucesso']);
        }

        if (isset($_SESSION['erro'])) {
            echo "<p class='mensagem-erro'>{$_SESSION['erro']}</p>";
            unset($_SESSION['erro']);
        }
        ?>

        <!-- Tabela com os filmes -->
        <table border="1" cellpadding="5" style="width: 100%; text-align: left; margin-top: 20px;">
            <tr style="background-color: #00adb5; color: white;">
                <th>Nome</th>
                <th>Diretor</th>
                <th>Valor</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($filmes as $filme): ?>
                <tr>
                    <td><?= htmlspecialchars($filme['nome']) ?></td>
                    <td><?= htmlspecialchars($filme['diretor']) ?></td>
                    <td>R$ <?= number_format($filme['valor'], 2, ',', '.') ?></td>
                    <td><?= $filme['estoque'] ?></td>
                    <td>
                        <a href="editar_filme.php?id=<?= $filme['id'] ?>">Editar</a>
                        <br> 
                        <a href="excluir_filme.php?id=<?= $filme['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Links para adicionar novo e sair -->
        <div class="botoes" style="margin-top: 30px;">
            <a href="formulario_filme.php">➕ Cadastrar Novo Filme</a>
            <a href="../autenticacao/logout.php">🚪 Sair</a>
            <a href="../index.php">🔙 Voltar à Página Inicial</a>
        </div>
    </div>
</body>
</html>
