<?php
include 'conexao.php';

function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) return false;

    // Elimina CPFs com todos os números iguais (ex: 11111111111)
    if (preg_match('/(\d)\1{10}/', $cpf)) return false;

    // Calcula o primeiro dígito verificador
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Verifica se o CPF é válido
    if (!validarCPF($cpf)) {
        $erro = "CPF inválido.";
        header("Location: cadastrar_area.php?erro=" . urlencode($erro) . "&nome=" . urlencode($nome) . "&telefone=" . urlencode($telefone) . "&cidade=" . urlencode($cidade) . "&estado=" . urlencode($estado));
        exit();
    }

    // Verifica se o CPF já está cadastrado
    $sql = "SELECT * FROM areas WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $erro = "Este CPF já está cadastrado.";
        header("Location: cadastrar_area.php?erro=" . urlencode($erro) . "&nome=" . urlencode($nome) . "&telefone=" . urlencode($telefone) . "&cidade=" . urlencode($cidade) . "&estado=" . urlencode($estado));
        exit();
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO areas (nome, cpf, telefone, cidade, estado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $cpf, $telefone, $cidade, $estado);

    if ($stmt->execute()) {
        header("Location: sucesso.php");
        exit();
    } else {
        $erro = "Erro: " . $stmt->error;
        header("Location: cadastrar_area.php?erro=" . urlencode($erro) . "&nome=" . urlencode($nome) . "&telefone=" . urlencode($telefone) . "&cidade=" . urlencode($cidade) . "&estado=" . urlencode($estado));
        exit();
    }

    $stmt->close();
}
$conn->close();
?>
