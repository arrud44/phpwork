<?php
// Inicia sessão para uso futuro, se necessário
session_start();

// Configurações de conexão com o banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'filmes_db';

// Cria conexão com o MySQL usando MySQLi
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Verifica se os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "<p style='color:red;'>Preencha todos os campos!</p>";
    } else {
        // Verifica se já existe um usuário com o mesmo e-mail
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "<p style='color:red;'>Este e-mail já está cadastrado.</p>";
        } else {
            // Cria hash seguro da senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Prepara a inserção do novo usuário no banco
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senhaHash);

            // Executa e verifica se o cadastro foi bem-sucedido
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Cadastro realizado com sucesso! <a href='login.php'>Clique aqui para entrar</a></p>";
            } else {
                echo "<p style='color:red;'>Erro ao cadastrar usuário.</p>";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <!-- Importa o estilo global -->
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="formulario-container">
        <h2>Cadastro de Novo Usuário</h2>
        <form method="post">
            <label>Nome:</label><br>
            <input type="text" name="nome" required><br><br>

            <label>E-mail:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Senha:</label><br>
            <input type="password" name="senha" required><br><br>

            <button type="submit">Cadastrar</button>
        </form>
        <br>
        <a href="login.php">Já tem conta? Entrar</a>
    </div>
</body>
</html>
