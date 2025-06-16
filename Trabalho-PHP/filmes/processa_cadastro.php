<?php
session_start();
require_once '../includes/conexao.php'; // Arquivo que cria a conexão com o banco e define $conn (objeto mysqli)

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/validacoes.php'; // Inclui funções de validação personalizadas

$usuario_id = $_SESSION['usuario_id'];

// Coleta os dados do formulário com segurança
$filme = [
    'nome'      => $_POST['nome'] ?? '',
    'diretor'   => $_POST['diretor'] ?? '',
    'valor'     => floatval($_POST['valor'] ?? 0),
    'estoque'   => intval($_POST['estoque'] ?? 0),
    'usuario_id'=> $usuario_id
];

// Validação dos dados usando função externa
if (!validar_filme($filme)) {
    $_SESSION['erro'] = "Preencha todos os campos obrigatórios!";
    header('Location: inventario.php');
    exit;
}

// Prepara o SQL para inserção de forma segura (evita SQL Injection)
$sql = "INSERT INTO filmes (nome, diretor, valor, estoque, usuario_id) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssdii", 
    $filme['nome'], 
    $filme['diretor'], 
    $filme['valor'], 
    $filme['estoque'], 
    $filme['usuario_id']
);

// Executa a inserção e trata o resultado
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['sucesso'] = "Filme cadastrado com sucesso!";
} else {
    $_SESSION['erro'] = "Erro ao cadastrar o filme.";
}

// Redireciona de volta para a tela de inventário
header('Location: inventario.php');
exit;
