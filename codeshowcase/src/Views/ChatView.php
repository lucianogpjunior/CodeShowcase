<?php
require_once __DIR__ . '/../../public/BaseLayout.php';
include __DIR__ . '/../../public/layouts/header.php';

$userId = (int) ($_SESSION['user']['id'] ?? 0);
$otherUserId = $userId === $compra->getCompradorId() ? $compra->getVendedorId() : $compra->getCompradorId();
$projectName = htmlspecialchars($project ? $project->getNomeProjeto() : 'Projeto');
?>
<main>
    <div class="chat-shell">
        <aside class="chat-sidebar">
            <div class="chat-header-block">
                <div class="container-badge">CHAT</div>
                <h2>Conversa do pedido</h2>
            </div>

            <div class="chat-project-card">
                <span class="text-muted">Projeto</span>
                <strong><?= $projectName ?></strong>
                <small>Valor: R$ <?= number_format($compra->getValor(), 2, ',', '.') ?></small>
            </div>

            <div class="chat-user-card">
                <span class="text-muted">Com</span>
                <strong><?= htmlspecialchars($_SESSION['user']['nome'] ?? 'Usuário') ?></strong>
            </div>

            <a href="/projetos" class="btn btn-outline" style="margin-top: 1rem;">Voltar</a>
        </aside>

        <section class="chat-panel">
            <div class="chat-topbar">
                <div>
                    <span class="text-muted">Atendimento</span>
                    <h3>Vendedor / comprador</h3>
                </div>
                <span class="chat-status online">Online</span>
            </div>

            <div id="chatMessages" class="chat-messages">
                <?php foreach ($mensagens as $msg): ?>
                    <div class="chat-message <?= $msg->getRemetenteId() === $userId ? 'mine' : 'other' ?>">
                        <div class="message-bubble">
                            <?= htmlspecialchars($msg->getMensagem()) ?>
                            <small><?= date('H:i', strtotime($msg->getCriadoEm() ?? date('Y-m-d H:i:s'))) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <form action="/chat/enviar" method="POST" class="chat-form">
                <input type="hidden" name="compra_id" value="<?= (int) $compra->getId() ?>">
                <textarea name="mensagem" rows="3" placeholder="Digite sua mensagem..." required></textarea>
                <div class="chat-form-actions">
                    <button type="submit" class="btn btn-accent">Enviar</button>
                </div>
            </form>
        </section>
    </div>
</main>

<script>
const chatMessages = document.getElementById('chatMessages');
const compraId = <?= (int) $compra->getId() ?>;
const currentUserId = <?= $userId ?>;

function loadMessages() {
    fetch('/chat/mensagens?compra_id=' + compraId)
        .then(response => response.json())
        .then(data => {
            if (!Array.isArray(data)) return;

            chatMessages.innerHTML = '';
            data.forEach((msg) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'chat-message ' + (msg.eh_minha ? 'mine' : 'other');
                const bubble = document.createElement('div');
                bubble.className = 'message-bubble';
                bubble.innerHTML = `${msg.mensagem.replace(/</g, '&lt;').replace(/>/g, '&gt;')}<small>${msg.criado_em ? msg.criado_em.slice(11, 16) : ''}</small>`;
                wrapper.appendChild(bubble);
                chatMessages.appendChild(wrapper);
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(() => {});
}

setInterval(loadMessages, 4000);
</script>

<?php include __DIR__ . '/../../public/layouts/footer.php'; ?>
