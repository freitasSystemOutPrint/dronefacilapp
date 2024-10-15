<?php
include('conexao.php'); // Conexão com o banco de dados

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$horas_voo = $_POST['horas_voo'];
$hectares = $_POST['hectares'];
$safras = $_POST['safras'];

// Função para validar CPF
function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf); // Remove caracteres não numéricos

    // Verifica se o CPF tem 11 dígitos ou se todos os dígitos são iguais
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Cálculo do dígito verificador
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

// Verificar se o CPF já está cadastrado
$sql = "SELECT * FROM pilotos WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $erro = "CPF já cadastrado.";
    header("Location: cadastrar_piloto.php?erro=" . urlencode($erro) . 
           "&nome=" . urlencode($nome) . 
           "&telefone=" . urlencode($telefone) . 
           "&cpf=" . urlencode($cpf) . 
           "&email=" . urlencode($email) . 
           "&horas_voo=" . urlencode($horas_voo) . 
           "&hectares=" . urlencode($hectares) . 
           "&safras=" . urlencode($safras));
    exit();
}

// Se o CPF for inválido
if (!validarCPF($cpf)) {
    $erro = "CPF inválido.";
    header("Location: cadastrar_piloto.php?erro=" . urlencode($erro) . 
           "&nome=" . urlencode($nome) . 
           "&telefone=" . urlencode($telefone) . 
           "&cpf=" . urlencode($cpf) . 
           "&email=" . urlencode($email) . 
           "&horas_voo=" . urlencode($horas_voo) . 
           "&hectares=" . urlencode($hectares) . 
           "&safras=" . urlencode($safras));
    exit();
}

// Inserindo no banco de dados
$sql = "INSERT INTO pilotos (nome, telefone, cpf, email, horas_voo, hectares, safras) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssiii", $nome, $telefone, $cpf, $email, $horas_voo, $hectares, $safras);

if ($stmt->execute()) {
    header("Location: sucesso.php"); // Redireciona para a página de sucesso
} else {
    $erro = "Erro ao cadastrar piloto.";
    header("Location: cadastrar_piloto.php?erro=" . urlencode($erro));
}
exit();
?>
