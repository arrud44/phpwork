<?php
// Gera o hash de uma senha utilizando o algoritmo padrão (atualmente BCRYPT)

// Defina a senha que você deseja gerar o hash
$senha = "teste1";

// Exibe o hash gerado
echo password_hash($senha, PASSWORD_DEFAULT);
?>
