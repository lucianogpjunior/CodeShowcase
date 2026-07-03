<?php require_once __DIR__ . '/../../public/BaseLayout.php'; ?>
<?php include __DIR__ . '/../../public/layouts/header.php'; ?>
<main>
    <div class="hero" style="padding: 1.5rem 0 1rem;">
        <div class="hero-eyebrow">✔ Compra realizada</div>
        <h1>Obrigado por sua compra!</h1>
        <p>Seu pedido foi processado com sucesso. Em breve você receberá um e-mail com os detalhes da compra.</p>
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            <a href="/projetos" class="btn btn-accent">Voltar aos projetos</a>
        </div>
    </div>
</main>
<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>