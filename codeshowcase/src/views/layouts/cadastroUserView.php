<?php include 'header.php'; ?>

    <div class="form-wrapper">
        <div class="container">
            <h1>Cadastro</h1>

            <form action="/src/controller/CadastroUserController.php" method="POST">

                <div class="input-group">
                    <label for="nome">Nome:</label>
                    <input id="idnome" name="nome" type="text" placeholder="Seu nome completo" required>
                </div>

                <div class="input-group">
                    <label for="email">Email:</label>
                    <input id="idemail" name="email" type="email" placeholder="seu@email.com" required>
                </div>

                <div class="input-group">
                    <label for="dtNascimento">Data de Nascimento:</label>
                    <input id="iddtNascimento" name="dtNascimento" type="date" required>
                </div>

                <div class="input-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="idcpf" name="cpf" maxlength="14" placeholder="000.000.000-00">
                </div>

                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input id="idsenha" name="senha" type="password" placeholder="Mínimo 8 caracteres" required>
                </div>

                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>

    <script>
    function validarCPF(cpf){
        
        cpf = cpf.replace(/\D/g, '');

        if(cpf.length !== 11) return false;

        if(/^(\d)\1+$/.test(cpf)) return false;

        let soma = 0;
        let resto;

        for(let i = 1; i <= 9; i++){
            soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
        }

        resto = (soma * 10) % 11;

        if(resto === 10 || resto === 11){
            resto = 0;
        }

        if(resto !== parseInt(cpf.substring(9, 10))){
            return false;
        }

        soma = 0;

        for(let i = 1; i <= 10; i++){
            soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
        }

        resto = (soma * 10) % 11;

        if(resto === 10 || resto === 11){
            resto = 0;
        }

        if(resto !== parseInt(cpf.substring(10, 11))){
            return false;
        }

        return true;
    }

    document.querySelector('form').addEventListener('submit', function(e){

        const cpf = cpfInput.value;

        if(!validarCPF(cpf)){

            alert('CPF inválido!');
            e.preventDefault();

        }

    });
    
</script>
<?php include 'footer.php'; ?>
</body>
</html>