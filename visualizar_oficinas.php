<?php
// Incluir a conexão com o banco de dados
include '../conexao.php';

// Consultar os dados da tabela oficinas
$sql = "SELECT * FROM oficinas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admDrone.css">
    <title>Visualizar Oficinas - Drone Fácil</title>
</head>
<body>

<div class="container">
    <h1>Visualizar Oficinas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sub Dealer</th>
                <th>CNPJ</th>
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
                        <td><?php echo $row['sub_dealer']; ?></td>
                        <td><?php echo $row['cnpj']; ?></td>
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
