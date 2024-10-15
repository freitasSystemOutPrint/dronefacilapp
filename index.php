<?php
// Incluir a conexão com o banco de dados
include '../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admDrone.css">
    <title>Painel Administrativo - Drone Fácil</title>
</head>
<body>

<div class="container">
    <h1>Painel Administrativo - Drone Fácil</h1>
    <div class="links">
        <a href="visualizar_drones.php" class="link">Visualizar Drones</a>
        <a href="visualizar_pilotos.php" class="link">Visualizar Pilotos</a>
        <a href="visualizar_areas.php" class="link">Visualizar Áreas</a>
        <a href="visualizar_oficinas.php" class="link">Visualizar Lojas</a>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Drone Fácil. Todos os direitos reservados.</p>
</footer>

</body>
</html>
