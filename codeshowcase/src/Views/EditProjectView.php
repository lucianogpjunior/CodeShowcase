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
                <div class="container-badge">editar</div>
                <h1>Editar projeto</h1>
                <p>Atualize os dados do projeto</p>
            </div>

            <form action="/projetos/atualizar" method="POST" enctype="multipart/form-data">

                <!-- ESSENCIAL: envia o ID para o controller saber qual projeto atualizar -->
                <input type="hidden" name="id" value="<?= $project->getId() ?>">

                <div class="input-group">
                    <label>Nome do projeto</label>
                    <!-- value preenchido com dado atual do projeto -->
                    <input type="text" name="nome_projeto"
                           value="<?= htmlspecialchars($project->getNomeProjeto()) ?>" required>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label>Preço (R$)</label>
                        <!-- value preenchido com dado atual do projeto -->
                        <input type="number" name="preco_projeto"
                               value="<?= $project->getPrecoProjeto() ?>"
                               min="0" step="0.01" required>
                    </div>

                    <div class="input-group">
                        <label>Categoria</label>
                        <select name="categoria_id" class="select-styled" required>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= $cat['id'] == $project->getCategoriaId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['categoria_nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Mostra imagem atual se existir -->
                <?php if ($project->getUrl()): ?>
                    <div class="input-group">
                        <label>Imagem atual</label>
                        <img src="<?= htmlspecialchars($project->getUrl()) ?>"
                             alt="Imagem atual"
                             style="width:100%; max-height:180px; object-fit:cover; border-radius:var(--radius-md); border:1px solid var(--border);">
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <label>Nova imagem (opcional)</label>
                    <!-- Não obrigatório — só substitui se enviar um novo arquivo -->
                    <input type="file" name="url" accept="image/jpeg,image/png,image/webp,image/gif">
                </div>

                <div class="input-group" style="flex-direction:row; align-items:center; gap:10px;">
                    <input type="checkbox" name="ativo" id="ativo"
                           <?= $project->getAtivo() ? 'checked' : '' ?>
                           style="width:16px; height:16px; accent-color:var(--accent);">
                    <label for="ativo" style="text-transform:none; font-size:14px; color:var(--muted);">
                        Projeto ativo (visível na listagem)
                    </label>
                </div>

                <button type="submit">Salvar alterações</button>

                <div class="form-footer">
                    <a href="/projetos">← Voltar para projetos</a>
                </div>

            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>