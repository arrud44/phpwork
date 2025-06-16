<?php
// Inicia a sessão para poder destruí-la
session_start();

// Destroi todas as variáveis da sessão (encerra o login do usuário)
session_destroy();

// Redireciona o usuário de volta para a tela de login
header("Location: login.php");
exit;
