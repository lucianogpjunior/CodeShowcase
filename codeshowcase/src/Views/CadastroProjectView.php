<?php require_once __DIR__ . '/../../public/BaseLayout.php'; ?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<style>
.select-styled {
    padding: 11px 14px;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    background: var(--surface-2);
    color: var(--text);
    font-size: 14px;
    font-family: var(--font-sans);
    outline: none;
    width: 100%;
    transition: border-color 0.2s;
}
.select-styled:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-dim);
}
</style>

<main>
    <div class="form-wrapper">
        <div class="container">
            <div class="container-header">
                <div class="container-badge">novo projeto</div>
                <h1>Cadastrar projeto</h1>
                <p>Preencha os dados do novo projeto</p>
            </div>

            <form action="/projetos/cadastrar" method="POST" enctype="multipart/form-data">

                <div class="input-group">
                    <label>Nome do projeto</label>
                    <input type="text" name="nome_projeto" placeholder="Ex: Sistema de Gestão" required>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label>Preço (R$)</label>
                        <input type="number" name="preco_projeto" placeholder="0.00" min="0" step="0.01" required>
                    </div>

                    <div class="input-group">
                        <label>Categoria</label>
                        <select name="categoria_id" class="select-styled" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>">
                                    <?= htmlspecialchars($cat['categoria_nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label>Imagem do projeto</label>
                    <input type="file" name="url" accept="image/jpeg,image/png,image/webp,image/gif" required>
                </div>

                <div class="input-group" style="flex-direction: row; align-items: center; gap: 10px;">
                    <input type="checkbox" name="ativo" id="ativo" checked
                           style="width:16px; height:16px; accent-color: var(--accent);">
                    <label for="ativo" style="text-transform:none; font-size:14px; color:var(--muted);">
                        Projeto ativo (visível na listagem)
                    </label>
                </div>

                <button type="submit">Cadastrar projeto</button>

                <div class="form-footer">
                    <a href="/projetos">← Voltar para projetos</a>
                </div>

            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>