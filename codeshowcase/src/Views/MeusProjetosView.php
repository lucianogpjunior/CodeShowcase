<?php require_once __DIR__ . '/../../public/BaseLayout.php'; ?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<style>
    .project-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .project-card__content {
        flex: 1;
    }

    .project-card__title {
        margin: 0 0 0.35rem;
        color: var(--text);
        font-size: 1.1rem;
    }

    .project-card__meta {
        color: var(--muted);
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .project-card__actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.75rem;
    }

    .project-card__actions a,
    .project-card__actions button {
        border: none;
        border-radius: var(--radius-md);
        padding: 0.6rem 0.85rem;
        text-decoration: none;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .btn-edit {
        background: var(--accent);
        color: white;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-secondary {
        background: var(--surface-2);
        color: var(--text);
        border: 1px solid var(--border);
    }

    .badge-status {
        display: inline-block;
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        font-size: 0.8rem;
        margin-bottom: 0.65rem;
        background: rgba(74, 222, 128, 0.16);
        color: #4ade80;
    }

    .badge-status.inativo {
        background: rgba(248, 113, 113, 0.16);
        color: #f87171;
    }
</style>

<main>
    <div class="hero" style="padding: 1.5rem 0 1rem;">
        <div class="hero-eyebrow">◆ Meus Projetos</div>
        <h1>Gerencie seus <span>projetos</span></h1>
        <p>Edite, desative ou exclua apenas os projetos vinculados ao seu cadastro de desenvolvedor.</p>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:0.75rem;">
        <a href="/projetos/cadastro" class="btn btn-accent">+ Cadastrar projeto</a>
        <a href="/projetos" class="btn btn-outline">Voltar para projetos</a>
    </div>

    <?php if (empty($projects)): ?>
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.5rem; text-align: center; color: var(--muted);">
            Nenhum projeto encontrado para o seu perfil de desenvolvedor.
        </div>
    <?php else: ?>
        <?php foreach ($projects as $project): ?>
            <article class="project-card">
                <div class="project-card__content">
                    <span class="badge-status <?= $project->getAtivo() ? '' : 'inativo' ?>">
                        <?= $project->getAtivo() ? 'Ativo' : 'Inativo' ?>
                    </span>
                    <h2 class="project-card__title"><?= htmlspecialchars($project->getNomeProjeto()) ?></h2>
                    <div class="project-card__meta">
                        <strong>Categoria:</strong> <?= htmlspecialchars($project->nomeCategoria ?? '—') ?>
                    </div>
                    <div class="project-card__meta">
                        <strong>Preço:</strong> R$ <?= number_format($project->getPrecoProjeto(), 2, ',', '.') ?>
                    </div>
                    <div class="project-card__meta">
                        <?= htmlspecialchars($project->getTitulo()) ?>
                    </div>

                    <div class="project-card__actions">
                        <a class="btn-edit" href="/projetos/editar?id=<?= (int) $project->getId() ?>">Editar</a>
                        <a class="btn-secondary" href="/projetos/desativar?id=<?= (int) $project->getId() ?>" onclick="return confirm('Deseja desativar este projeto?')">Desativar</a>
                        <a class="btn-danger" href="/projetos/deletar?id=<?= (int) $project->getId() ?>" onclick="return confirm('Deseja excluir este projeto permanentemente?')">Excluir</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>
