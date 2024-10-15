<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sub_dealer = $_POST['sub_dealer'];
    $cnpj = $_POST['cnpj'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Verifica se o CNPJ já está cadastrado
    $verifica_cnpj = "SELECT COUNT(*) FROM oficinas WHERE cnpj = ?";
    $stmt_verifica = $conn->prepare($verifica_cnpj);
    $stmt_verifica->bind_param("s", $cnpj);
    $stmt_verifica->execute();
    $stmt_verifica->bind_result($count);
    $stmt_verifica->fetch();
    $stmt_verifica->close();

    if ($count > 0) {
        $erro = "Erro: CNPJ já cadastrado.";
        header("Location: cadastrar_oficina.php?erro=" . urlencode($erro) . "&nome=" . urlencode($nome) . "&sub_dealer=" . urlencode($sub_dealer) . "&cnpj=" . urlencode($cnpj) . "&cidade=" . urlencode($cidade) . "&estado=" . urlencode($estado));
        exit();
    }

    // Se o CNPJ não estiver cadastrado, prossegue para o cadastro
    $sql = "INSERT INTO oficinas (nome, sub_dealer, cnpj, cidade, estado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $sub_dealer, $cnpj, $cidade, $estado);

    if ($stmt->execute()) {
        header("Location: sucesso.php");
        exit();
    } else {
        $erro = "Erro: " . $stmt->error;
        header("Location: cadastrar_oficina.php?erro=" . urlencode($erro) . "&nome=" . urlencode($nome) . "&sub_dealer=" . urlencode($sub_dealer) . "&cnpj=" . urlencode($cnpj) . "&cidade=" . urlencode($cidade) . "&estado=" . urlencode($estado));
        exit();
    }

    $stmt->close();
}
$conn->close();
