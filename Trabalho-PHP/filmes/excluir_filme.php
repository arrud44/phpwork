<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/conexao.php'; // Inclui conexão com o banco

$usuario_id = $_SESSION['usuario_id'];
$filme_id = $_GET['id'] ?? null;

// Verifica se o ID do filme foi passado pela URL
if (!$filme_id) {
    $_SESSION['erro'] = "Filme não encontrado.";
    header('Location: inventario.php');
    exit;
}

// Verifica se o filme pertence ao usuário logado
$sql = "SELECT * FROM filmes WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $filme_id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$filme = $resultado->fetch_assoc();

if (!$filme) {
    $_SESSION['erro'] = "Filme não encontrado ou você não tem permissão para excluí-lo.";
    header('Location: inventario.php');
    exit;
}

// Se tudo certo, exclui o filme do banco
$sql = "DELETE FROM filmes WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $filme_id, $usuario_id);
$stmt->execute();

// Define mensagem de sucesso e redireciona
$_SESSION['sucesso'] = "Filme excluído com sucesso!";
header('Location: inventario.php');
exit;
