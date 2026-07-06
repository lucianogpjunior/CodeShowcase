<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>
<main>
    <div class="pagamento-container">
        <h1>Pagamento</h1>
        <p>Você está prestes a comprar o projeto: <strong><?= htmlspecialchars($project['nome']) ?></strong></p>
        <p>Valor: R$ <?= number_format($project['valor'], 2, ',', '.') ?></p>

        <form action="/comprar/processar" method="POST">
            <input type="hidden" name="uuid" value="<?= htmlspecialchars($project['uuid']) ?>">

            <div class="input-group">
                <label for="idcartao">Número do Cartão:</label>
                <input id="idcartao" name="cartao" type="text" required>
            </div>

            <div class="input-group">
                <label for="idvalidade">Validade:</label>
                <input id="idvalidade" name="validade" type="text" placeholder="MM/AA" required>
            </div>

            <div class="input-group">
                <label for="idcvv">CVV:</label>
                <input id="idcvv" name="cvv" type="text" maxlength="3" required>
            </div>

            <button type="submit">Pagar</button>
        </form>
    </div>
<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>