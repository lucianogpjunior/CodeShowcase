<?php require_once __DIR__ . '/../../public/BaseLayout.php'; ?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<style>
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(4px);
    z-index: 200;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.modal-overlay.open {
    display: flex;
}

.modal {
    background: var(--surface);
    border: 1px solid var(--border-accent);
    border-radius: var(--radius-xl);
    width: 100%;
    max-width: 680px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 32px 80px rgba(0,0,0,0.8);
    animation: modalIn 0.2s ease;
}

@keyframes modalIn {
    from { opacity: 0; transform: translateY(16px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

.modal-image {
    width: 100%;
    height: 240px;
    object-fit: cover;
    border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    display: block;
}

.modal-image-placeholder {
    width: 100%;
    height: 160px;
    background: var(--surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    font-size: 13px;
    font-family: var(--font-mono);
    border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    border-bottom: 1px solid var(--border);
}

.modal-body {
    padding: 1.75rem 2rem 2rem;
}

.modal-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 0.75rem;
    flex-wrap: wrap;
}

.modal-badge {
    display: inline-flex;
    align-items: center;
    background: var(--accent-dim);
    border: 1px solid rgba(139,92,246,0.2);
    border-radius: 999px;
    padding: 3px 12px;
    font-size: 11px;
    font-family: var(--font-mono);
    color: var(--accent-text);
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.modal-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-family: var(--font-mono);
    color: var(--muted);
}

.modal-status::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #4ADE80;
}

.modal-status.inativo::before { background: #F87171; }

.modal-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text);
    letter-spacing: -0.02em;
    margin-bottom: 1.25rem;
}

.modal-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding: 1.25rem;
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
}

.modal-info-item label {
    display: block;
    font-size: 10px;
    font-weight: 500;
    color: var(--muted);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 3px;
}

.modal-info-item span {
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
}

.modal-info-item span.price {
    color: var(--accent-text);
    font-size: 18px;
}

.modal-info-item span.uuid {
    font-family: var(--font-mono);
    font-size: 10px;
    word-break: break-all;
    color: var(--muted);
    font-weight: 400;
}

.modal-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    padding-top: 1.25rem;
    border-top: 1px solid var(--border);
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(0,0,0,0.5);
    border: 1px solid rgba(255,255,255,0.1);
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
    z-index: 10;
}

.modal-close:hover { background: rgba(255,255,255,0.15); }

.modal-wrapper { position: relative; }
</style>

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
                <div class="card"
                     style="cursor: pointer;"
                     onclick='abrirModal(
                        <?= json_encode($project->getNomeProjeto()) ?>,
                        <?= json_encode($project->getUrl()) ?>,
                        <?= json_encode($project->nomeCategoria ?? "—") ?>,
                        <?= json_encode(number_format($project->getPrecoProjeto(), 2, ",", ".")) ?>,
                        <?= json_encode($project->getAtivo() ? "ativo" : "inativo") ?>,
                        <?= json_encode($project->getUuid()) ?>,
                        <?= json_encode($project->getId()) ?>

                     )'>

                    <?php if ($project->getUrl()): ?>
                        <img
                            src="<?= htmlspecialchars($project->getUrl()) ?>"
                            alt="<?= htmlspecialchars($project->getNomeProjeto()) ?>"
                            style="width:100%; height:160px; object-fit:cover; border-radius:var(--radius-md); margin-bottom:0.5rem;"
                        >
                    <?php endif; ?>

                    <span class="card-icon"><?= htmlspecialchars($project->nomeCategoria ?? '—') ?></span>
                    <h2><?= htmlspecialchars($project->getNomeProjeto()) ?></h2>
                    <p style="color:var(--accent-text); font-weight:600;">
                        R$ <?= number_format($project->getPrecoProjeto(), 2, ',', '.') ?>
                    </p>
                    <p style="font-size:12px; color:var(--muted); margin-top:0.25rem;">
                        Clique para ver detalhes
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<!-- Modal de detalhes -->
<div class="modal-overlay" id="modalOverlay" onclick="fecharModalOverlay(event)">
    <div class="modal modal-wrapper">
        <button class="modal-close" onclick="fecharModal()">✕</button>

        <div id="modalImageContainer"></div>

        <div class="modal-body">
            <div class="modal-meta">
                <span class="modal-badge" id="modalCategoria"></span>
                <span class="modal-status" id="modalStatus"></span>
            </div>

            <h2 class="modal-title" id="modalNome"></h2>

            <div class="modal-info-grid">
                <div class="modal-info-item">
                    <label>Preço</label>
                    <span class="price" id="modalPreco"></span>
                </div>
                <div class="modal-info-item">
                    <label>Categoria</label>
                    <span id="modalCategoriaInfo"></span>
                </div>
                <div class="modal-info-item" style="grid-column: span 2;">
                    <label>UUID</label>
                    <span class="uuid" id="modalUuid"></span>
                </div>
            </div>

            <div class="modal-actions">
                <a id="modalBtnComprar" href="/projetos/comprar" class="btn btn-accent">Comprar</a>
                <a id="modalBtnEditar" href="/projetos/editar" class="btn btn-outline">Editar projeto</a>
                <a id="modalBtnDesativar" href="/projetos/desativar"
                   class="btn btn-outline"
                   style="color:#F87171; border-color:rgba(248,113,113,0.3);"
                   onclick="return confirm('Tem certeza que deseja desativar este projeto?')">
                    Desativar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function abrirModal(nome, url, categoria, preco, status, uuid, id) {
    const imgContainer = document.getElementById('modalImageContainer');
    if (url) {
        imgContainer.innerHTML = '<img src="' + url + '" alt="' + nome + '" class="modal-image">';
    } else {
        imgContainer.innerHTML = '<div class="modal-image-placeholder">sem imagem</div>';
    }

    document.getElementById('modalNome').textContent          = nome;
    document.getElementById('modalCategoria').textContent     = categoria;
    document.getElementById('modalCategoriaInfo').textContent = categoria;
    document.getElementById('modalPreco').textContent         = 'R$ ' + preco;
    document.getElementById('modalUuid').textContent          = uuid;
  
    var statusEl = document.getElementById('modalStatus');
    statusEl.textContent = status === 'ativo' ? 'Ativo' : 'Inativo';
    statusEl.className   = status === 'inativo' ? 'modal-status inativo' : 'modal-status';



    document.getElementById('modalBtnComprar').href   = '/projetos/comprar?uuid=' + id;
    document.getElementById('modalBtnEditar').href    = '/projetos/editar?uuid=' + uuid;
    document.getElementById('modalBtnDesativar').href = '/projetos/desativar?uuid=' + uuid;

    document.getElementById('modalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function fecharModal() {
    document.getElementById('modalOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

function fecharModalOverlay(event) {
    if (event.target === document.getElementById('modalOverlay')) {
        fecharModal();
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') fecharModal();
});
</script>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>