<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="cadastro-container">
        <h1>Login</h1>
        <form action="/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo \App\Config\Security::generateCsrfToken(); ?>">

            <div class="input-group">
                <label for="idlogin">Nome de usuário ou email:</label>
                <input id="idlogin" name="login" type="text" required>
            </div>

            <div class="input-group">
                <label for="idsenha">Senha:</label>
                <input id="idsenha" name="senha" type="password" required>
            </div>

            <button type="submit">Entrar</button>
        </form>
    </div>
</main>

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
</style>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>