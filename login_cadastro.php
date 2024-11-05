<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nome_de_historia";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_confirmacao = $_POST['senha_confirmacao'];
    $tipo = $_POST['tipo'];

    // Verifica se as senhas coincidem
    if ($senha !== $senha_confirmacao) {
        echo "<script>alert('As senhas não coincidem.');</script>";
    } else {
        // Se as senhas coincidirem, continua com o registro
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        if ($tipo === 'professor') {
            $sql = "INSERT INTO professores (nome, email, senha) VALUES ('$nome', '$email', '$senha_hash')";
        } else {
            $sql = "INSERT INTO alunos (nome, email, senha) VALUES ('$nome', '$email', '$senha_hash')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            // Redireciona para a página de login
            header("Location: login.php");
            exit; // Certifique-se de sair após o redirecionamento
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>
        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <label for="senha_confirmacao">Confirme a Senha:</label>
            <input type="password" id="senha_confirmacao" name="senha_confirmacao" required>
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" required>
                <option value="professor">Professor</option>
                <option value="aluno">Aluno</option>
            </select>
            <button type="submit" name="action" value="register">Cadastrar</button>
        </form>
    </div>
</body>
</html>
