<?php
session_start(); // Inicia a sessão para acessar variáveis de sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver logado, redireciona para a tela de login
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Registro de Filme</title>
    
    <!-- Importa o estilo da pasta css -->
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <!-- Container visual com estilo padronizado -->
    <div class="formulario-container">
        <h1>Registro de Filme</h1>

        <!-- Formulário que envia dados para processa_cadastro.php -->
        <form action="processa_cadastro.php" method="post">
            <label for="nome">Nome do Filme:</label><br />
            <input type="text" id="nome" name="nome" required /><br /><br />

            <label for="diretor">Diretor:</label><br />
            <input type="text" id="diretor" name="diretor" required /><br /><br />

            <label for="valor">Preço unitário (R$):</label><br />
            <input type="number" id="valor" name="valor" step="0.01" min="0.01" required /><br /><br />

            <label for="estoque">Quantidade em estoque:</label><br />
            <input type="number" id="estoque" name="estoque" min="1" step="1" required /><br /><br />

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
