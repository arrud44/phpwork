<?php
// Dados de conexão com o banco de dados
$host = 'localhost';        // Endereço do servidor (localhost em ambiente local)
$usuario = 'root';          // Usuário padrão do XAMPP/WAMP
$senha = '';                // Senha (em branco no XAMPP por padrão)
$dbname = 'filmes_db';      // Nome do banco de dados utilizado

// Cria a conexão com o MySQL usando a extensão mysqli
$conn = new mysqli($host, $usuario, $senha, $dbname);

// Verifica se houve erro na tentativa de conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}

// Define o charset padrão para UTF-8 (evita problemas com acentos e caracteres especiais)
$conn->set_charset("utf8");
?>
