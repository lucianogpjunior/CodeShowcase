<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>

<?php include __DIR__ . '/../../public/css/layouts/header.php'; ?>
<main>
    <h1>Bem-vindo ao Code Showcase</h1>
    <p>Explore nossos projetos, tutoriais e recursos para desenvolvedores.</p>

    <div class="cards-container">
        <div class="card">
            <h2>Projetos Recentes</h2>
            <p>Confira os nossos projetos mais recentes e inovadores.</p>
            <a href="#">Ver Projetos</a>
        </div>
        <div class="card">
            <h2>Tutoriais</h2>
            <p>Aprenda novas habilidades com nossos tutoriais detalhados.</p>
            <a href="#">Ver Tutoriais</a>
        </div>
        <div class="card">
            <h2>Recursos</h2>
            <p>Acesse uma variedade de recursos úteis para desenvolvedores.</p>
            <a href="#">Ver Recursos</a>
        </div>
    </div>

</main>

</body>
<?php include __DIR__ . '/../../public/css/layouts/footer.php'; ?>