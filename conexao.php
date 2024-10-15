<?php
// Exibindo erros para depuração (remova em produção)
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Configurações do banco de dados
$servername = "localhost"; // ou o seu servidor
$username = "root"; // substitua pelo seu usuário
$password = ""; // substitua pela sua senha
$dbname = "drone_facil"; // nome do banco de dados que você criou

// Criando conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
