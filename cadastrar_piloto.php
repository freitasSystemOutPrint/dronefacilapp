<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Piloto - Drone Fácil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Cadastrar Piloto</h1>
</header>

<main class="main-form">
    <form action="processa_piloto.php" method="POST">
        <label for="nome">Nome e Sobrenome:</label>
        <input type="text" id="nome" name="nome" required 
               value="<?php echo isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : ''; ?>">

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required pattern="[0-9]{11}" 
               placeholder="Apenas números" 
               value="<?php echo isset($_GET['telefone']) ? htmlspecialchars($_GET['telefone']) : ''; ?>">

        <label for="cpf">CPF:</label>
        <div id="mensagem" style="color: red; margin-bottom: 10px;">
            <?php
            if (isset($_GET['erro'])) {
                echo htmlspecialchars($_GET['erro']);
            }
            ?>
        </div>
        <input type="text" id="cpf" name="cpf" required pattern="[0-9]{11}" 
               placeholder="Apenas números" 
               value="<?php echo isset($_GET['cpf']) ? htmlspecialchars($_GET['cpf']) : ''; ?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required 
               value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">

        <label for="horas_voo">Horas de Voo:</label>
        <input type="number" id="horas_voo" name="horas_voo" required 
               value="<?php echo isset($_GET['horas_voo']) ? htmlspecialchars($_GET['horas_voo']) : ''; ?>">

        <label for="hectares">Hectares Pulverizados:</label>
        <input type="number" id="hectares" name="hectares" required 
               value="<?php echo isset($_GET['hectares']) ? htmlspecialchars($_GET['hectares']) : ''; ?>">

        <label for="safras">Número de Safras:</label>
        <input type="number" id="safras" name="safras" required 
               value="<?php echo isset($_GET['safras']) ? htmlspecialchars($_GET['safras']) : ''; ?>">

        <button type="submit">Cadastrar</button>
    </form>
</main>

</body>
</html>
