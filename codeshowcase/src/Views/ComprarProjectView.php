<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>
<?php
$palavras = explode(' ', $project->getNomeProjeto());
$ultima = array_pop($palavras);
$resto = implode(' ', $palavras);
?>
<main>
    <section class="hero">
        <div class="hero-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: center;">
            <div>
                <div class="hero-eyebrow">CODESHOWCASE</div>
                <h1><?= htmlspecialchars($resto . ' ') ?><span><?= htmlspecialchars($ultima) ?></span></h1>
                <p>Confira os detalhes deste projeto disponível para compra.</p>
                <div class="hero-actions">
                    <a href="#valores" class="btn btn-accent">Comprar agora</a>
                    <?php if (!empty($project->getUrl())): ?>
                        <a href="<?= htmlspecialchars($project->getUrl()) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline">Preview</a>
                    <?php endif; ?>
                    <a href="/projetos" class="btn btn-outline">Voltar</a>
                </div>
            </div>
            <div>
                <img src="<?= htmlspecialchars($project->getImage()) ?>"
                     alt="<?= htmlspecialchars($project->getNomeProjeto()) ?>"
                     style="width:100%; max-height:360px; object-fit:contain; border-radius: var(--radius-lg);">
            </div>
        </div>
    </section>

    <section style="margin-top: 3rem;">
        <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">O que você recebe</h2>
        <div class="cards-container">
            <div class="card">
                <span class="card-icon">CÓDIGO</span>
                <h2>Código-fonte completo</h2>
                <p>Acesso total ao repositório e todos os arquivos do projeto.</p>
            </div>
            <div class="card">
                <span class="card-icon">SUPORTE</span>
                <h2>Suporte direto</h2>
                <p>Tire dúvidas diretamente com o desenvolvedor original.</p>
            </div>
            <div class="card">
                <span class="card-icon">DOCS</span>
                <h2>Documentação</h2>
                <p>Instruções claras de instalação e configuração.</p>
            </div>
        </div>
    </section>

    <section id="valores" style="margin-top: 3rem; width: 100%; display: flex; justify-content: center;">
        <div class="container" style="text-align: center; max-width: 420px; width: 100%;">
            <div class="container-badge">OFERTA</div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--text); margin: 0.75rem 0;">
                R$ <?= htmlspecialchars(number_format($project->getPrecoProjeto(), 2, ',', '.')) ?>
            </div>
            <p style="color: var(--muted); margin-bottom: 1.5rem;">
                Pagamento único, acesso vitalício ao código-fonte.
            </p>
            <a href="/projetos/pagamento?id=<?= $project->getId() ?>" class="btn btn-accent">
                Comprar agora
            </a>        
        </div>
    </section>
</main>
<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>