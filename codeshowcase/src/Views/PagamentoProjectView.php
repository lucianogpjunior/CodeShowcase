<?php require_once __DIR__ . '/../../public/BaseLayout.php'; ?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>

<main>
    <div class="payment-wrapper">
        <div class="payment-container">
            <!-- Cabeçalho -->
            <div style="margin-bottom: 2rem;">
                <div class="container-badge">💳 Pagamento</div>
                <h1 style="font-size: 24px; margin-bottom: 4px;">Finalizar compra</h1>
                <p style="color: var(--muted);">
                    Projeto: <strong><?= htmlspecialchars($project->getNomeProjeto()) ?></strong>
                </p>
            </div>

            <!-- Mensagem de erro -->
            <?php if (!empty($_SESSION['erro_pagamento'])): ?>
                <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #F87171; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
                    ✕ <?= htmlspecialchars($_SESSION['erro_pagamento']) ?>
                </div>
                <?php unset($_SESSION['erro_pagamento']); ?>
            <?php endif; ?>

            <!-- Resumo -->
            <div class="payment-summary">
                <h3 style="font-size: 14px; color: var(--muted); margin-bottom: 0.5rem;">📋 Resumo</h3>
                <div class="payment-summary-grid">
                    <div class="payment-summary-item">
                        <span class="payment-summary-label">Projeto</span>
                        <span class="payment-summary-value"><?= htmlspecialchars($project->getNomeProjeto()) ?></span>
                    </div>
                    <!-- No resumo do pedido -->
                    <div class="payment-summary-item">
                        <span class="payment-summary-label">Categoria</span>
                        <span class="payment-summary-value">
                            <?php 
                            $categoriaNome = 'Não definida';
                            foreach ($categorias as $cat) {
                                if ($cat['id'] == $project->getCategoriaId()) {
                                    $categoriaNome = $cat['categoria_nome'];
                                    break;
                                }
                            }
                            echo htmlspecialchars($categoriaNome);
                            ?>
                        </span>
                    </div>
                    <div class="payment-summary-item">
                        <span class="payment-summary-label">Valor</span>
                        <span class="payment-summary-value highlight">R$ <?= number_format($project->getPrecoProjeto(), 2, ',', '.') ?></span>
                    </div>
                    <div class="payment-summary-item">
                        <span class="payment-summary-label">Pagamento</span>
                        <span class="payment-summary-value" id="metodoSelecionado">Selecione</span>
                    </div>
                </div>
            </div>

            <!-- Métodos -->
            <div class="payment-methods-grid">
                <div class="payment-method-option">
                    <input type="radio" name="metodo" id="metodo_cartao" value="cartao" checked>
                    <label for="metodo_cartao">
                        <span class="payment-method-icon">💳</span>
                        Cartão
                        <span class="payment-method-badge">popular</span>
                    </label>
                </div>
                <div class="payment-method-option">
                    <input type="radio" name="metodo" id="metodo_pix" value="pix">
                    <label for="metodo_pix">
                        <span class="payment-method-icon">📱</span>
                        PIX
                        <span class="payment-method-badge">rápido</span>
                    </label>
                </div>
                <div class="payment-method-option">
                    <input type="radio" name="metodo" id="metodo_boleto" value="boleto">
                    <label for="metodo_boleto">
                        <span class="payment-method-icon">📄</span>
                        Boleto
                        <span class="payment-method-badge">3 dias</span>
                    </label>
                </div>
            </div>

            <!-- Formulário -->
            <form action="/comprar/processar" method="POST">
                <input type="hidden" name="uuid" value="<?= htmlspecialchars($project->getUuid()) ?>">
                <input type="hidden" name="metodo" id="metodoInput" value="cartao">

                <!-- Cartão -->
                <div class="payment-form active" id="form_cartao">
                    <div class="input-group">
                        <label for="idcartao">Número do Cartão</label>
                        <input id="idcartao" name="cartao" type="text" placeholder="0000 0000 0000 0000" maxlength="19" required>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="idvalidade">Validade</label>
                            <input id="idvalidade" name="validade" type="text" placeholder="MM/AA" maxlength="5" required>
                        </div>
                        <div class="input-group">
                            <label for="idcvv">CVV</label>
                            <input id="idcvv" name="cvv" type="text" maxlength="4" placeholder="000" required>
                        </div>
                    </div>
                </div>

                <!-- PIX -->
                <div class="payment-form" id="form_pix">
                    <div style="text-align: center; padding: 1rem 0;">
                        <div style="font-size: 48px; margin-bottom: 0.5rem;">📱</div>
                        <p style="color: var(--muted);">Escaneie o QR Code ou copie o código</p>
                        <div style="background: white; width: 150px; height: 150px; margin: 1rem auto; border-radius: var(--radius-md); border: 2px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 12px; color: #999;">
                            QR Code
                        </div>
                        <div style="background: var(--surface-2); padding: 10px; border-radius: var(--radius-sm); font-family: monospace; font-size: 12px; word-break: break-all; margin-bottom: 0.5rem;">
                            <?= $pixCode ?? '00020126360014br.gov.bcb.pix...' ?>
                        </div>
                        <button type="button" onclick="alert('Copiado!')" style="background: var(--accent-dim); border: none; padding: 8px 20px; border-radius: var(--radius-sm); color: var(--accent-text); cursor: pointer;">
                            📋 Copiar
                        </button>
                    </div>
                </div>

                <!-- Boleto -->
                <div class="payment-form" id="form_boleto">
                    <div style="text-align: center; padding: 1rem 0;">
                        <div style="font-size: 48px; margin-bottom: 0.5rem;">📄</div>
                        <p style="color: var(--muted); margin-bottom: 1rem;">Boleto gerado e enviado por e-mail</p>
                        <div style="background: var(--surface-2); border-radius: var(--radius-md); padding: 1rem; text-align: left;">
                            <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid var(--border);">
                                <span style="color: var(--muted);">Vencimento</span>
                                <span><?= date('d/m/Y', strtotime('+3 days')) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 6px 0;">
                                <span style="color: var(--muted);">Valor</span>
                                <span style="font-weight: 600;">R$ <?= number_format($project->getPrecoProjeto(), 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="payment-actions">
                    <a href="/projetos" class="btn-secondary" style="padding: 14px 24px; background: transparent; border: 1px solid var(--border); border-radius: var(--radius-md); color: var(--muted); text-decoration: none; text-align: center;">← Voltar</a>
                <!-- Usando <a> igual ao voltar -->
                <a href="/comprar/sucesso?uuid=<?= htmlspecialchars($project->getUuid()) ?>" class="btn-payment" id="btnPagamento" style="text-decoration: none; text-align: center; display: inline-block;">
                    <span id="btnTexto">Confirmar pagamento</span>
                </a>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- JS simples -->
<script>
// Trocar método
document.querySelectorAll('input[name="metodo"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const metodo = this.value;
        
        document.querySelectorAll('.payment-form').forEach(f => f.classList.remove('active'));
        document.getElementById('form_' + metodo).classList.add('active');
        document.getElementById('metodoInput').value = metodo;
        
        const nomes = { cartao: '💳 Cartão', pix: '📱 PIX', boleto: '📄 Boleto' };
        document.getElementById('metodoSelecionado').textContent = nomes[metodo];
        document.getElementById('btnTexto').textContent = nomes[metodo] + ' - Confirmar';
    });
});

// Máscaras básicas
document.getElementById('idcartao')?.addEventListener('input', function(e) {
    let v = this.value.replace(/\D/g, '');
    v = v.replace(/(\d{4})(\d)/g, '$1 $2');
    this.value = v.substring(0, 19);
});

document.getElementById('idvalidade')?.addEventListener('input', function(e) {
    let v = this.value.replace(/\D/g, '');
    if (v.length >= 2) v = v.substring(0, 2) + '/' + v.substring(2, 4);
    this.value = v;
});

document.getElementById('idcvv')?.addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});
</script>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>