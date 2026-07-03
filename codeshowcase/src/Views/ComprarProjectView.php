<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>
<?php
$palavras = explode(' ', $project->getNomeProjeto());
$ultima = array_pop($palavras); 
$resto =  implode(' ', $palavras);
?>
<section class="hero">
    <div class="hero-grid">
        <div>
            <div class="hero-eyebrow">CODESHOWCASE</div>
            <h1><?= htmlspecialchars($resto . ' ')?><span><?=htmlspecialchars($ultima)?></span></h1>
            <p>Confira os detalhes deste projeto disponível para compra.</p>
            <div class="hero-actions">
                <a href="#valores" class="btn btn-accent">Comprar agora</a>
                <a href="/projetos" class="btn btn-outline">Voltar</a>
            </div>
        </div>
        <div>
            <img src="<?= htmlspecialchars($project->getUrl()) ?>" alt="<?= htmlspecialchars($project->getNomeProjeto()) ?>" style="width:100%; border-radius: var(--radius-lg);">
        </div>
    </div>
</section>
    <div class="container" style="text-align: center;">
        <div class="container-badge">OFERTA</div>
        <h1 style="margin-bottom: 1rem;">
            R$ <?= htmlspecialchars(number_format($project->getPrecoProjeto(), 2, ',', '.')) ?>
        </h1>
        <p style="margin-bottom: 1.5rem;">Pagamento único, acesso vitalício ao código-fonte.</p>
        <a href="/comprar/sucesso" class="btn btn-accent" style="width:100%; justify-content:center;">
            Comprar agora
        </a>
    </div>
</section>
<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>

