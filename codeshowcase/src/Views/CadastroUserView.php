<?php
// BaseLayout abre <html>, <head> e <body>
require_once __DIR__ . '/../../public/BaseLayout.php';
?>

<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="cadastro-container">
        <h1>Cadastrar</h1>

        <form action="/cadastro-user" method="POST">
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
                <input id="idemail" name="email" type="email" required placeholder="Ex: joao@example.com">
            </div>

            <div class="input-group">
                <label for="iddtNascimento">Data de Nascimento:</label>
                <input id="iddtNascimento" name="dtNascimento" type="date" required>
            </div>

            <div class="input-group">
                <label for="idsenha">Senha:</label>
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

    /*
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

document.querySelector('form').addEventListener('submit', function (e) {
    // CORRIGIDO: cpfInput não estava declarado, causava ReferenceError
    const cpfInput = document.getElementById('idcpf');
    const cpf = cpfInput.value;

    if (!validarCPF(cpf)) {
        alert('CPF inválido!');
        e.preventDefault();
    }
});*/
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