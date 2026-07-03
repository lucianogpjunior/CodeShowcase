<?php require_once __DIR__ . '/../../public/BaseLayout.php'; ?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="hero" style="padding: 1.5rem 0 1rem;">
        <div class="hero-eyebrow">◆ Projetos</div>
        <h1>Projetos <span>disponíveis</span></h1>
        <p>Explore todos os projetos publicados na plataforma.</p>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-bottom: 1rem;">
        <a href="/projetos/cadastro" class="btn btn-accent">+ Novo projeto</a>
    </div>

    <?php if (empty($projects)): ?>
        <p style="color: var(--muted); text-align: center; margin-top: 3rem;">
            Nenhum projeto cadastrado ainda.
        </p>
    <?php else: ?>
        <div class="cards-container">
            <?php foreach ($projects as $project): ?>
                <div class="card">
                    <?php if ($project->getUrl()): ?>
                        <img
                            src="<?= htmlspecialchars($project->getUrl()) ?>"
                            alt="<?= htmlspecialchars($project->getNomeProjeto()) ?>"
                            style="width:100%; height:160px; object-fit:cover; border-radius: var(--radius-md); margin-bottom: 0.5rem;"
                        >
                    <?php endif; ?>

                    <span class="card-icon"><?= htmlspecialchars($project->nomeCategoria ?? '—') ?></span>
                    <h2><?= htmlspecialchars($project->getNomeProjeto()) ?></h2>
                    <p style="color: var(--accent-text); font-weight: 600;">
                        R$ <?= number_format($project->getPrecoProjeto(), 2, ',', '.') ?>
                    </p>

                    <div style="display: flex; gap: 8px; margin-top: 0.75rem;">
                        <a href="/projetos/comprar?id=<?= $project->getId() ?>" class="btn btn-accent" style="padding: 6px 14px; font-size: 13px;">
                            Comprar
                        </a>
                        <a href="/projetos/editar?id=<?= $project->getId() ?>" class="btn btn-outline" style="padding: 6px 14px; font-size: 13px;">
                            Editar
                        </a>
                        <a href="/projetos/desativar?id=<?= $project->getId() ?>" class="btn btn-outline" style="padding: 6px 14px; font-size: 13px; color: #F87171; border-color: rgba(248,113,113,0.3);"
                           onclick="return confirm('Tem certeza que deseja desativar este projeto?')">
                            Desativar
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>