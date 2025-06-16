<?php
// Inicia a sessão
session_start();

// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'filmes_db';
$usuario = 'root';
$senha = ''; // deixe em branco se estiver usando XAMPP padrão

// Cria conexão
$conn = new mysqli($host, $usuario, $senha, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura e sanitiza os dados do formulário
    $email = $_POST['email'] ?? '';
    $senhaDigitada = $_POST['senha'] ?? '';

    // Prepara a consulta SQL segura (evita SQL Injection)
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    // Verifica se o usuário existe e se a senha está correta
    if ($usuario && password_verify($senhaDigitada, $usuario['senha'])) {
        // Autenticação bem-sucedida: salva dados na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_email'] = $usuario['email'];

        // Redireciona para a página de cadastro de filmes
        header("Location: ../filmes/formulario_filme.php");
        exit;
    } else {
        // Mensagem de erro em caso de falha de login
        $erro = "E-mail ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <div class="formulario-container">
        <h2>Login</h2>

        <!-- Exibe mensagem de erro caso ocorra -->
        <?php if (isset($erro)): ?>
            <p class="mensagem-erro"><?= $erro ?></p>
        <?php endif; ?>

        <!-- Formulário de login -->
        <form method="POST" action="login.php">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required><br><br>

            <button type="submit">Entrar</button>
        </form>

        <p>Não tem uma conta? <a href="cadastro_USU.php">Se cadastrar</a></p>
    </div>
</body>
</html>
