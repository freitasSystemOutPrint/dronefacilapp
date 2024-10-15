<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Loja ou Oficina - Drone Fácil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script>
    function validarCNPJ(cnpj) {
        // Código de validação do CNPJ aqui
    }

    function verificarCNPJ() {
        // Código de verificação do CNPJ aqui
    }
</script>

    <script>
        function validarCNPJ(cnpj) {
            cnpj = cnpj.replace(/\D/g, ''); // Remove caracteres não numéricos

            if (cnpj.length !== 14) {
                return false; // O CNPJ deve ter 14 dígitos
            }

            // Cálculo dos dígitos verificadores
            let tamanho = cnpj.length - 2;
            let numeros = cnpj.substring(0, tamanho);
            let digitos = cnpj.substring(tamanho);
            let soma = 0;
            let pos = tamanho - 7;

            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }

            let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
            if (resultado != digitos.charAt(0)) return false; // Verifica o primeiro dígito

            tamanho++;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;

            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }

            resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
            return resultado == digitos.charAt(1); // Verifica o segundo dígito
        }

        function verificarCNPJ() {
            const cnpjInput = document.getElementById('cnpj');
            const mensagem = document.getElementById('mensagem');
            const cnpj = cnpjInput.value;

            if (!validarCNPJ(cnpj)) {
                mensagem.innerText = 'CNPJ inválido.';
                cnpjInput.value = ''; // Limpa o campo
                return false;
            }

            // Se o CNPJ for válido, continua com a verificação no banco de dados
            mensagem.innerText = '';
            fetch('verifica_cnpj.php?cnpj=' + cnpj)
                .then(response => response.text())
                .then(data => {
                    if (data === 'existe') {
                        mensagem.innerText = 'CNPJ já cadastrado.';
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar CNPJ:', error);
                });
        }
    </script>
</head>
<body>
    <header>
        <h1>Cadastrar Loja ou Oficina</h1>
    </header>

    <main class="main-form">
        <form action="processa_oficina.php" method="POST">
            <label for="nome">Nome e Sobrenome:</label>
            <input type="text" id="nome" name="nome" required value="<?php echo isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : ''; ?>">

            <label for="sub_dealer">Sub Dealer:</label>
            <input type="text" id="sub_dealer" name="sub_dealer" required value="<?php echo isset($_GET['sub_dealer']) ? htmlspecialchars($_GET['sub_dealer']) : ''; ?>">

            <label for="cnpj">CNPJ:</label>
            <div id="mensagem" style="color: red; margin-bottom: 10px;">
                <?php if (isset($_GET['erro'])) echo htmlspecialchars($_GET['erro']); ?>
            </div>
            <input type="text" id="cnpj" name="cnpj" required placeholder="Apenas números" onblur="verificarCNPJ()" value="<?php echo isset($_GET['cnpj']) ? htmlspecialchars($_GET['cnpj']) : ''; ?>">

            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" required value="<?php echo isset($_GET['cidade']) ? htmlspecialchars($_GET['cidade']) : ''; ?>">

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" required maxlength="2" placeholder="Sigla (Ex: SP)" value="<?php echo isset($_GET['estado']) ? htmlspecialchars($_GET['estado']) : ''; ?>">

            <button type="submit" style="margin-top: 10px;">Cadastrar</button>

        </form>
    </main>
    <footer>
        <p>&copy; 2024 Drone Fácil. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
a