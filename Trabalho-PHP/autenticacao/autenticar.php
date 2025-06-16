<?php
// Inicia a sessão para controle de login
session_start();

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'filmes_db';
$usuario = 'root';
$senha = ''; // Em ambientes locais com XAMPP geralmente não há senha

// Cria conexão com o banco de dados usando MySQLi
$conn = new mysqli($host, $usuario, $senha, $dbname);

// Verifica se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Captura os dados enviados pelo formulário (via POST)
$email = $_POST['email'] ?? '';
$senhaDigitada = $_POST['senha'] ?? '';

// Prepara uma consulta SQL segura para buscar o usuário com o e-mail informado
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email); // 's' indica que estamos passando uma string
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc(); // Retorna o usuário como array associativo

// Verifica se o usuário existe e se a senha digitada está correta usando password_verify
if ($usuario && password_verify($senhaDigitada, $usuario['senha'])) {
    // Login bem-sucedido: armazena informações na sessão
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_email'] = $usuario['email'];

    // Redireciona para o formulário de cadastro de filmes
    header("Location: formulario_filme.php");
    exit;
} else {
    // Login falhou: mostra mensagem de erro e link para tentar novamente
    echo "<div class='mensagem-erro'>E-mail ou senha inválidos. <a href='login.php'>Tentar novamente</a></div>";
}
?>
