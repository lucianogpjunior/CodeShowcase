<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>

<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="hero">
        <div class="hero-eyebrow">◆ Code Showcase</div>
        <h1>Explore, aprenda e <span>compartilhe</span> projetos</h1>
        <p>Uma plataforma para desenvolvedores descobrirem projetos, tutoriais e recursos de qualidade.</p>
        <div class="hero-actions">
            <a href="/cadastro" class="btn btn-accent">Criar conta</a>
            <a href="#" class="btn btn-outline">Ver projetos →</a>
        </div>
    </div>

    <div class="cards-container">
        <div class="card">
            <span class="card-icon">projetos</span>
            <h2>Projetos Recentes</h2>
            <p>Confira os nossos projetos mais recentes e inovadores.</p>
            <a href="#">Ver Projetos</a>
        </div>
        <div class="card">
            <span class="card-icon">tutoriais</span>
            <h2>Tutoriais</h2>
            <p>Aprenda novas habilidades com nossos tutoriais detalhados.</p>
            <a href="#">Ver Tutoriais</a>
        </div>
        <div class="card">
            <span class="card-icon">recursos</span>
            <h2>Recursos</h2>
            <p>Acesse uma variedade de recursos úteis para desenvolvedores.</p>
            <a href="#">Ver Recursos</a>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>