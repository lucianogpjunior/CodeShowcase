<?php
// BaseLayout abre <html>, <head> e <body>
require_once __DIR__ . '/../../public/BaseLayout.php';
?>

<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="cadastro-container">
        <h1>Cadastrar</h1>

        <form action="/cadastro-user" method="POST">

            <div class="input-group">
                <label for="idnome">Nome:</label>
                <input id="idnome" name="nome" type="text" required>
                <!-- Mensagem de erro do Nome -->
                <span id="mensagem-erro" class="erro-oculto">Nome inválido. Use apenas letras.</span>
            <input type="hidden" name="csrf_token" value="<?php echo \App\Config\Security::generateCsrfToken(); ?>">

            <div class="input-group">
                <label for="idnomeUsuario">Nome de usuário:</label>
                <input id="idnomeUsuario" name="nome_usuario" type="text" required placeholder="Ex: usuario123">
            </div>

            <div class="input-group">
                <label for="idnome">Nome:</label>
                <input id="idnome" name="nome" type="text" required placeholder="Ex: João da Silva">
            </div>

            <div class="input-group">
                <label for="idemail">Email:</label>
                <input id="idemail" name="email" type="email" required>
                <!-- Mensagem de erro do Email -->
                <span id="mensagem-erro-email" class="erro-oculto">Email inválido (ex: usuario@email.com).</span>
                <input id="idemail" name="email" type="email" required placeholder="Ex: joao@example.com">

            </div>

            <div class="input-group">
                <label for="iddtNascimento">Data de Nascimento:</label>
                <input id="iddtNascimento" name="dtNascimento" type="date" required>
                <!-- Mensagem de erro da Data -->
                <span id="mensagem-erro-data" class="erro-oculto">Data inválida. Não pode ser no futuro nem ter mais de 100 anos.</span>
            </div>

            <div class="input-group">
                <label for="idcpf">CPF:</label>
                <input
                    type="text"
                    id="idcpf"
                    name="cpf"
                    maxlength="14"
                    placeholder="000.000.000-00"
                    required
                >
                <!-- Mensagem de erro do CPF -->
                <span id="mensagem-erro-cpf" class="erro-oculto">CPF inválido. Verifique os números.</span>
            </div>

            <div class="input-group">
                <label for="idsenha">Senha:</label>
                <input id="idsenha" name="senha" type="password" required>
                <!-- Mensagem de erro da Senha -->
                <span id="mensagem-erro-senha" class="erro-oculto">Senha fraca. Deve ter no mínimo 8 caracteres, maiúsculas, minúsculas, números e caractere especial.</span>
                <div style="position: relative;">
                    <input id="idsenha" name="senha" type="password" required>
                    <button type="button" id="togglePassword" aria-label="Mostrar senha" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--text); cursor: pointer; padding: 0; display: flex; align-items: center; justify-content: center;">
                        <span class="mdi mdi-eye" style="font-size: 1.1rem;"></span>
                    </button>
                </div>

            </div>

            <button type="submit">Cadastrar</button>

        </form>
    </div>
</main>

<script>

// ==========================================
// 1. FUNÇÕES DE VALIDAÇÃO (LÓGICA)
// ==========================================
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('idsenha');
        const toggleButton = document.getElementById('togglePassword');

        if (passwordInput && toggleButton) {
            toggleButton.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggleButton.innerHTML = isPassword
                    ? '<span class="mdi mdi-eye-off" style="font-size: 1.1rem;"></span>'
                    : '<span class="mdi mdi-eye" style="font-size: 1.1rem;"></span>';
            });
        }
    });
function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11) return false;
    if (/^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    let resto;
    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    soma = 0;
    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

function validarNome(nome) {
    const regex = /^[A-Za-zÀ-ÿ\s]+$/;
    return regex.test(nome);
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validarDataNascimento(data) {
    if (!data) return false;
    const hoje = new Date();
    const dataNascimento = new Date(data);
    const dataLimite = new Date();
    dataLimite.setFullYear(hoje.getFullYear() - 100);
    return dataNascimento < hoje && dataNascimento >= dataLimite;
}

function validarSenha(senha) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return regex.test(senha);
}

// ==========================================
// 2. EVENTO SUBMIT ÚNICO DO FORMULÁRIO
// ==========================================

document.querySelector('form').addEventListener('submit', function (e) {
    // Variável de controle para saber se todo o formulário está correto
    let formularioValido = true;

    // --- VALIDAÇÃO: NOME ---
    const nomeInput = document.getElementById('idnome');
    const mensagemErroNome = document.getElementById('mensagem-erro'); // Mantido ID original
    if (!validarNome(nomeInput.value)) {
        nomeInput.classList.add('input-com-erro');
        mensagemErroNome.classList.add('erro');
        formularioValido = false;
    } else {
        nomeInput.classList.remove('input-com-erro');
        mensagemErroNome.classList.remove('erro');
    }

    // --- VALIDAÇÃO: CPF ---
    const cpfInput = document.getElementById('idcpf');
    const mensagemErroCpf = document.getElementById('mensagem-erro-cpf');
    if (!validarCPF(cpfInput.value)) {
        cpfInput.classList.add('input-com-erro');
        mensagemErroCpf.classList.add('erro');
        formularioValido = false;
    } else {
        cpfInput.classList.remove('input-com-erro');
        mensagemErroCpf.classList.remove('erro');
    }

    // --- VALIDAÇÃO: EMAIL ---
    const emailInput = document.getElementById('idemail');
    const mensagemErroEmail = document.getElementById('mensagem-erro-email');
    if (!validarEmail(emailInput.value)) {
        emailInput.classList.add('input-com-erro');
        mensagemErroEmail.classList.add('erro');
        formularioValido = false;
    } else {
        emailInput.classList.remove('input-com-erro');
        mensagemErroEmail.classList.remove('erro');
    }

    // --- VALIDAÇÃO: DATA DE NASCIMENTO ---
    const dtNascimentoInput = document.getElementById('iddtNascimento');
    const mensagemErroData = document.getElementById('mensagem-erro-data');
    if (!validarDataNascimento(dtNascimentoInput.value)) {
        dtNascimentoInput.classList.add('input-com-erro');
        mensagemErroData.classList.add('erro');
        formularioValido = false;
    } else {
        dtNascimentoInput.classList.remove('input-com-erro');
        mensagemErroData.classList.remove('erro');
    }

    // --- VALIDAÇÃO: SENHA ---
    const senhaInput = document.getElementById('idsenha');
    const mensagemErroSenha = document.getElementById('mensagem-erro-senha');
    if (!validarSenha(senhaInput.value)) {
        senhaInput.classList.add('input-com-erro');
        mensagemErroSenha.classList.add('erro');
        formularioValido = false;
    } else {
        senhaInput.classList.remove('input-com-erro');
        mensagemErroSenha.classList.remove('erro');
    }

    // BLOQUEIO FINAL: Se houver qualquer erro, impede o envio do formulário
    if (!formularioValido) {
        e.preventDefault();
    }
});
</script>

<style>
    .cadastro-container {
        margin: 100px auto;
        width: 100%;
        max-width: 440px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        box-shadow: 0 8px 32px var(--shadow-md);
    }

    .password-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-wrapper input {
        width: 100%;
        padding-right: 2.8rem;
    }

    .password-input-wrapper button {
        position: absolute;
        right: 0.35rem;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: var(--muted);
        cursor: pointer;
        padding: 0.3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .password-input-wrapper button:hover {
        background: var(--surface-2);
        color: var(--text);
    }

    .password-input-wrapper .mdi {
        font-size: 1.05rem;
    }
</style>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>

