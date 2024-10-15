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

        // Verifica se o CNPJ é válido
        if (!validarCNPJ(cnpj)) {
            mensagem.innerText = 'CNPJ inválido.';
            cnpjInput.value = ''; // Limpa o campo
            return false; // Não submete o formulário
        }

        // Se o CNPJ for válido, continua com a verificação no banco de dados
        mensagem.innerText = '';
        fetch('verifica_cnpj.php?cnpj=' + cnpj)
            .then(response => response.text())
            .then(data => {
                if (data === 'existe') {
                    mensagem.innerText = 'CNPJ já cadastrado.';
                    return false; // Não submete o formulário
                } else {
                    // Se o CNPJ não existir, submeta o formulário
                    document.querySelector('form').submit(); // Submete o formulário
                }
            })
            .catch(error => {
                console.error('Erro ao verificar CNPJ:', error);
            });
    }

    // Adicione o evento de clique ao botão "Cadastrar"
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            event.preventDefault(); // Previne a submissão padrão
            verificarCNPJ(); // Chama a função de verificação
        });
    });
</script>
