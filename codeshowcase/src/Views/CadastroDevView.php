<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="cadastro-container">
        <h1>Cadastro Desenvolvedor</h1>
        <p>Para publicar projetos no marketplace, é necessário registrar seu perfil de desenvolvedor.</p>

        <form action="/dev/cadastrar" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo \App\Config\Security::generateCsrfToken(); ?>">
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
</style>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>