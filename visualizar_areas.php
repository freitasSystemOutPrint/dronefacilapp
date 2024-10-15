<?php
// Incluir a conexão com o banco de dados
include '../conexao.php';

// Consultar os dados da tabela áreas
$sql = "SELECT * FROM areas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admDrone.css">
    <title>Visualizar Áreas - Drone Fácil</title>
</head>
<body>

<div class="container">
    <h1>Visualizar Áreas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Cidade</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['cpf']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td><?php echo $row['cidade']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum dado encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2024 Drone Fácil. Todos os direitos reservados.</p>
</footer>

</body>
</html>
