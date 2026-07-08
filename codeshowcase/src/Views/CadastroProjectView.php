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
                    <input type="text" name="nome" placeholder="Ex: Sistema de Gestão" required>
                </div>

                <div class="input-group">
                    <label>Título do projeto</label>
                    <input type="text" name="titulo" placeholder="Ex: Plataforma de vendas" required>
                </div>

                <div class="input-group">
                    <label>Descrição</label>
                    <textarea name="descricao" rows="4" placeholder="Descreva o projeto" required></textarea>
                </div>

                <div class="input-group">
                    <label>URL do projeto (opcional)</label>
                    <input type="url" name="url" placeholder="https://exemplo.com">
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label>Preço (R$)</label>
                        <input type="number" name="preco" placeholder="0.00" min="0" step="0.01" required>
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
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif" required>
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
<script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const precoInput = form.querySelector('input[name="preco_projeto"]');
        const precoValue = parseFloat(precoInput.value);

        if (isNam(e(precoValue) || precoValue < 0)) {
            event.preventDefault();
            alert('O preço do projeto deve ser um número positivo.');
        }
    })

    function validarNome(nome) {
        const regex = /^[A-Za-zÀ-ÿ0-9\s.,'-]+$/;
        return regex.test(nome);
    }

    document.querySelector('form').addEventListener('submit', function (e) {
        const nomeInput = document.querySelector('input[name="nome_projeto"]');
        const nome = nomeInput.value;

         if (!validarNome(nome)) {
            alert('Nome do projeto inválido! Use apenas letras, números e caracteres especiais básicos.');
            e.preventDefault();
         }
    })
</script>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>