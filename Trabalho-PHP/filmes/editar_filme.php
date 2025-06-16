<?php
session_start();
require_once '../includes/conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$filme_id = $_GET['id'] ?? null;

// Verifica se o ID do filme foi fornecido
if (!$filme_id) {
    echo "Filme não encontrado.";
    exit;
}

// Busca o filme do usuário logado
$sql = "SELECT * FROM filmes WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $filme_id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$filme = $resultado->fetch_assoc();

// Se não encontrar ou não for do usuário logado
if (!$filme) {
    echo "Filme não encontrado ou sem permissão.";
    exit;
}

// Se for um envio de formulário (POST), atualiza os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $diretor = $_POST['diretor'] ?? '';
    $valor = $_POST['valor'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    // Atualiza o filme com os novos dados
    $sql = "UPDATE filmes SET nome = ?, diretor = ?, valor = ?, estoque = ? WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdiii", $nome, $diretor, $valor, $estoque, $filme_id, $usuario_id);
    $stmt->execute();

    // Redireciona após salvar
    header("Location: inventario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Filme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="formulario-container">
        <h1>Editar Filme</h1>
        <form method="post">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($filme['nome']) ?>" required>

            <label for="diretor">Diretor:</label>
            <input type="text" name="diretor" id="diretor" value="<?= htmlspecialchars($filme['diretor']) ?>" required>

            <label for="valor">Valor:</label>
            <input type="number" name="valor" id="valor" step="0.01" value="<?= htmlspecialchars($filme['valor']) ?>" required>

            <label for="estoque">Estoque:</label>
            <input type="number" name="estoque" id="estoque" value="<?= $filme['estoque'] ?>" required>

            <button type="submit">Salvar</button>
        </form>
        <br>
        <div class="botoes">
            <a href="inventario.php">← Voltar</a>
            <a href="logout.php">Sair</a>
        </div>
    </div>
</body>
</html>
