<?php
// Incluir a conexão com o banco de dados
include '../conexao.php';

// Consultar os dados da tabela pilotos
$sql = "SELECT * FROM pilotos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admDrone.css">
    <title>Visualizar Pilotos - Drone Fácil</title>
</head>
<body>

<div class="container">
    <h1>Visualizar Pilotos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Horas de Voo</th>
                <th>Hectares</th>
                <th>Safras</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td><?php echo $row['cpf']; ?></td>
                        <td><?php echo $row['horas_voo']; ?></td>
                        <td><?php echo $row['hectares']; ?></td>
                        <td><?php echo $row['safras']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Nenhum dado encontrado.</td>
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
