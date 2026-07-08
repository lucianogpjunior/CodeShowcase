<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<style>
.produto-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: start;
    margin-top: 2rem;
}

.produto-imagem {
    position: sticky;
    top: 90px;
}

.produto-imagem img {
    width: 100%;
    aspect-ratio: 1/1;
    object-fit: cover;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
}

.produto-info {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.produto-categoria {
    display: inline-flex;
    align-items: center;
    background: var(--accent-dim);
    border: 1px solid rgba(139,92,246,0.2);
    border-radius: 999px;
    padding: 4px 14px;
    font-size: 11px;
    font-family: var(--font-mono);
    color: var(--accent-text);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    width: fit-content;
}

.produto-titulo {
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 600;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.produto-preco-label {
    font-size: 12px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-family: var(--font-mono);
}

.produto-preco {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--accent-text);
    letter-spacing: -0.02em;
    line-height: 1;
}

.produto-preco span {
    font-size: 1rem;
    font-weight: 500;
    color: var(--muted);
    margin-left: 4px;
}

.produto-divider {
    height: 1px;
    background: var(--border);
}

.produto-incluso {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.produto-incluso-titulo {
    font-size: 12px;
    font-weight: 500;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-family: var(--font-mono);
    margin-bottom: 0.25rem;
}

.produto-incluso-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: var(--text);
}

.produto-incluso-item::before {
    content: '✓';
    color: var(--accent-text);
    font-weight: 700;
    font-size: 13px;
    flex-shrink: 0;
}

.produto-btn-comprar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 24px;
    background: var(--accent);
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    font-family: var(--font-sans);
    border-radius: var(--radius-md);
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
    width: 100%;
    text-align: center;
}

.produto-btn-comprar:hover {
    background: var(--accent-hover);
    transform: translateY(-1px);
}

.produto-btn-voltar {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    background: transparent;
    color: var(--muted);
    font-size: 14px;
    font-weight: 500;
    font-family: var(--font-sans);
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    text-decoration: none;
    transition: color 0.2s, border-color 0.2s;
    width: 100%;
    text-align: center;
}

.produto-btn-voltar:hover {
    color: var(--text);
    border-color: rgba(139,92,246,0.4);
}

.produto-seguro {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--muted);
    justify-content: center;
    font-family: var(--font-mono);
}

.produto-seguro::before {
    content: '🔒';
    font-size: 13px;
}

/* Seção benefícios */
.beneficios-section {
    margin-top: 4rem;
    padding-top: 3rem;
    border-top: 1px solid var(--border);
}

.beneficios-titulo {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 1.5rem;
    letter-spacing: -0.01em;
}

@media (max-width: 768px) {
    .produto-wrapper {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .produto-imagem {
        position: static;
    }
}
</style>

<main>
    <?php
    $palavras = explode(' ', $project->getNomeProjeto());
    $ultima   = array_pop($palavras);
    $resto    = implode(' ', $palavras);
    ?>

    <a href="/projetos" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--muted); text-decoration:none; margin-top:1rem; transition:color 0.2s;"
       onmouseover="this.style.color='var(--accent-text)'"
       onmouseout="this.style.color='var(--muted)'">
        ← Voltar para projetos
    </a>

    <div class="produto-wrapper">

        <!-- Imagem -->
        <div class="produto-imagem">
            <?php if ($project->getImage()): ?>
                <img src="<?= htmlspecialchars($project->getImage()) ?>"
                     alt="<?= htmlspecialchars($project->getNomeProjeto()) ?>">
            <?php else: ?>
                <div style="width:100%; aspect-ratio:1/1; background:var(--surface-2); border-radius:var(--radius-lg); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--muted); font-family:var(--font-mono); font-size:13px;">
                    sem imagem
                </div>
            <?php endif; ?>
        </div>

        <!-- Informações -->
        <div class="produto-info">

            <span class="produto-categoria">
                <?= htmlspecialchars($project->nomeCategoria ?? '—') ?>
            </span>

            <h1 class="produto-titulo">
                <?= htmlspecialchars($resto . ' ') ?><span style="color:var(--accent-text);"><?= htmlspecialchars($ultima) ?></span>
            </h1>

            <div>
                <div class="produto-preco-label">Preço</div>
                <div class="produto-preco">
                    R$ <?= number_format($project->getPrecoProjeto(), 2, ',', '.') ?>
                    <span>pagamento único</span>
                </div>
            </div>

            <div class="produto-divider"></div>

            <div class="produto-incluso">
                <div class="produto-incluso-titulo">O que está incluso</div>
                <div class="produto-incluso-item">Código-fonte completo</div>
                <div class="produto-incluso-item">Suporte direto com o desenvolvedor</div>
                <div class="produto-incluso-item">Documentação de instalação</div>
                <div class="produto-incluso-item">Acesso vitalício</div>
            </div>

            <div class="produto-divider"></div>

            <div style="display:flex; flex-direction:column; gap:10px;">
                <a href="/projetos/pagamento?id=<?= htmlspecialchars($project->getId()) ?>"
                   class="produto-btn-comprar">
                    Comprar agora — R$ <?= number_format($project->getPrecoProjeto(), 2, ',', '.') ?>
                </a>
                <a href="/projetos" class="produto-btn-voltar">Voltar para projetos</a>
                <div class="produto-seguro">Compra 100% segura</div>
            </div>

        </div>
    </div>

    <!-- Seção benefícios -->
    <div class="beneficios-section">
        <h2 class="beneficios-titulo">Por que comprar aqui?</h2>
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
    </div>

</main>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>