<?php
session_start(); // Inicia a sessão

// Impede o acesso a usuários não autenticados
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'conexao.php'; // Inclui o arquivo de conexão com o banco de dados

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Captura e sanitiza os dados do formulário
    $nome = trim($_POST['nome'] ?? '');
    $diretor = trim($_POST['diretor'] ?? '');
    $valor = floatval($_POST['valor'] ?? 0);
    $estoque = intval($_POST['estoque'] ?? 0);
    $usuario_id = $_SESSION['usuario_id'];

    // Validação básica: campos obrigatórios
    if (empty($nome) || empty($diretor)) {
        $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
        header('Location: inventario.php');
        exit;
    }

    // Prepara a inserção no banco com segurança (prepared statement)
    $sql = "INSERT INTO filmes (nome, diretor, valor, estoque, usuario_id) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $nome, $diretor, $valor, $estoque, $usuario_id);

    // Executa e define a mensagem de sucesso ou erro
    if ($stmt->execute()) {
        $_SESSION['sucesso'] = 'Filme cadastrado com sucesso!';
    } else {
        $_SESSION['erro'] = 'Erro ao cadastrar filme.';
    }

    // Redireciona para o inventário após o processo
    header('Location: inventario.php');
    exit;
} else {
    // Caso alguém tente acessar esse script diretamente via GET, redireciona
    header('Location: inventario.php');
    exit;
}
