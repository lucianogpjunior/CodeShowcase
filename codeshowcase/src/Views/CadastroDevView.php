<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="cadastro-container">
        <h1>Cadastro Desenvolvedor</h1>
        <p>Para publicar projetos no marketplace, é necessário registrar seu perfil de desenvolvedor.</p>

        <form action="/dev/cadastrar" method="POST" class="dev-form">
            <input type="hidden" name="csrf_token" value="<?php echo \App\Config\Security::generateCsrfToken(); ?>">

            <div class="form-group">
                <label for="github_url_perfil">URL do GitHub</label>
                <input type="url" id="github_url_perfil" name="github_url_perfil" placeholder="https://github.com/seu-usuario" required>
            </div>

            <div class="form-group">
                <label for="linkedin_url">URL do LinkedIn</label>
                <input type="url" id="linkedin_url" name="linkedin_url" placeholder="https://www.linkedin.com/in/seu-perfil" required>
            </div>

            <button type="submit">Quero me tornar desenvolvedor</button>
        </form>
    </div>
</main>

<style>
    .cadastro-container {
        margin: 100px auto;
        width: 100%;
        max-width: 600px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2rem;
        box-shadow: 0 8px 32px var(--shadow-md);
    }

    .dev-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 600;
    }

    .form-group input {
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
    }
</style>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>