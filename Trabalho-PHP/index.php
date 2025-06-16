<?php
// Inicia a sessão para controle de login
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Bem-vindo ao Sistema de Filmes</title>

    <!-- Importa o estilo principal -->
    <link rel="stylesheet" href="style.css"/> 
</head>
<body>
    <div class="formulario-container">
        <h1>🎬 Bem-vindo ao Sistema de Filmes</h1>

        <!-- Subtítulo de boas-vindas -->
        <p style="text-align: center; font-weight: 500;">
            Gerencie seus filmes de forma simples e prática.
        </p>

        <!-- Botões para login ou cadastro -->
        <div class="botoes">
            <a href="autenticacao/login.php">Fazer Login</a>
            <a href="autenticacao/cadastro_USU.php">Cadastrar-se</a>
        </div>

        <!-- Créditos do trabalho -->
        <p style="margin-top: 30px; text-align: center; font-size: 14px; color: #aaaaaa;">
            Trabalho de: <strong>Eduardo Arruda</strong> e <strong>Adryan Portella</strong>
        </p>
    </div>
</body>
</html>
