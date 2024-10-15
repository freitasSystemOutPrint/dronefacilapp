<?php
// Habilitar exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexao.php'; // Conexão com o banco

// Função para validar CPF
function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf); // Remove caracteres não numéricos

    if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false; // CPF inválido se não tiver 11 dígitos ou todos forem iguais
    }

    // Verificação dos dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($c = 0; $c < $t; $c++) {
            $soma += $cpf[$c] * (($t + 1) - $c);
        }
        $digito = ($soma * 10) % 11;
        if ($digito == 10 || $digito == 11) {
            $digito = 0;
        }
        if ($digito != $cpf[$t]) {
            return false; // CPF inválido
        }
    }
    return true;
}

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $tipo_drone = $_POST['tipo_drone'];

    // Valida o CPF
    if (!validarCPF($cpf)) {
        $erro = "Erro: CPF inválido.";
        header("Location: cadastrar_drone.php?erro=" . urlencode($erro) .
               "&nome=" . urlencode($nome) .
               "&telefone=" . urlencode($telefone) .
               "&cpf=" . urlencode($cpf) .
               "&email=" . urlencode($email) .
               "&tipo_drone=" . urlencode($tipo_drone));
        exit();
    }

    // Verifica se o CPF já está cadastrado
    $verifica_cpf = "SELECT COUNT(*) FROM drones WHERE cpf = ?";
    $stmt_verifica = $conn->prepare($verifica_cpf);

    if (!$stmt_verifica) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt_verifica->bind_param("s", $cpf);
    $stmt_verifica->execute();
    $stmt_verifica->bind_result($count);
    $stmt_verifica->fetch();
    $stmt_verifica->close();

    if ($count > 0) {
        $erro = "Erro: CPF já cadastrado.";
        header("Location: cadastrar_drone.php?erro=" . urlencode($erro) .
               "&nome=" . urlencode($nome) .
               "&telefone=" . urlencode($telefone) .
               "&cpf=" . urlencode($cpf) .
               "&email=" . urlencode($email) .
               "&tipo_drone=" . urlencode($tipo_drone));
        exit();
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO drones (nome, telefone, cpf, email, tipo_drone) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a inserção: " . $conn->error);
    }

    $stmt->bind_param("sssss", $nome, $telefone, $cpf, $email, $tipo_drone);

    try {
        $stmt->execute();
        header("Location: sucesso.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Captura erros de duplicidade e exibe mensagem personalizada
        if ($e->getCode() == 1062) {
            $erro = "Erro: CPF já cadastrado.";
        } else {
            $erro = "Erro: " . $e->getMessage();
        }
        header("Location: cadastrar_drone.php?erro=" . urlencode($erro) .
               "&nome=" . urlencode($nome) .
               "&telefone=" . urlencode($telefone) .
               "&cpf=" . urlencode($cpf) .
               "&email=" . urlencode($email) .
               "&tipo_drone=" . urlencode($tipo_drone));
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
