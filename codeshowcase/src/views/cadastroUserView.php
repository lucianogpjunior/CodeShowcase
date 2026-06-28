<?php

require_once __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../../public/BaseLayout.php';
?>

<div class="header">
    <?php include __DIR__ . '/../../public/css/layouts/header.php'; ?>
</div>

<head>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="cadastro-container">
        <h1>Cadastrar</h1>

        <form action="/cadastro-user" method="POST">

            <div class="input-group">
                <label for="nome">Nome:</label>
                <input id="idnome" name="nome" type="text" required>
            </div>

            <div class="input-group">
                <label for="email">Email:</label>
                <input id="idemail" name="email" type="email" required>
            </div>

            <div class="input-group">
                <label for="dtNascimento">Data de Nascimento:</label>
                <input id="iddtNascimento" name="dtNascimento" type="date" required>
            </div>

            <div class="input-group">
                <label for="cpf">CPF:</label>

                <input 
                    type="text"
                    id="idcpf"
                    name="cpf"
                    maxlength="14"
                    placeholder="000.000.000-00"
                >
            </div>

            <div class="input-group">
                <label for="senha">Senha:</label>
                <input id="idsenha" name="senha" type="text" required>
            </div>

            <button type="submit">Cadastrar</button>
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
</body>
</html>

<div class="footer">
    <?php include __DIR__ . '/../../public/css/layouts/footer.php'; ?>
</div>

<style scoped>
    .cadastro-container{
        margin: 100px auto;
        padding: 20px;
       width: 100%;
       max-width: 440px;
       background: var(--surface);
       border: 1px solid var(--border);
       border-radius: var(--radius-xl);
       padding: 2.5rem 2rem;
       box-shadow: 0 8px 32px var(--shadow-md)
    }
</style>