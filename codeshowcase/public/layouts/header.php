<?php
// header.php — não inclui BaseLayout (já carregado pela view)
?>

<nav class="navbar">
    <div style="display: flex; align-items: center;">
        <img src="/assets/favicon.ico" class="logo" alt="Logo">
    </div>

    <div class="nav-links" id="menu">
        <a href="/home">Home</a>
        <a href="#">Recursos</a>
        <a href="/projetos">Projetos</a>
        <a href="#">Tutoriais</a>
    </div>

    <div class="auth-links">
        <a href="/login">Login</a>
        <a href="/cadastro" class="btn-primary">Cadastrar</a>
    </div>

    <div class="navbar-buttons">
        <button id="themeBtn" class="theme-btn" onclick="trocarTema()" aria-label="Alternar tema">
            <img id="themeIcon" src="/assets/moon.png" alt="Tema">
        </button>
        <button class="menu-btn" onclick="abrirMenu()">☰</button>
    </div>
</nav>

<script>
(function () {
    const body = document.body;
    const icon = document.getElementById("themeIcon");

    // Padrão é dark — aplica light só se salvo
    const saved = localStorage.getItem("theme");
    if (saved === "light") {
        body.classList.add("light");
        icon.src = "/assets/sun.png";
    }

    window.trocarTema = function () {
        const isLight = body.classList.toggle("light");
        icon.src = isLight ? "/assets/sun.png" : "/assets/moon.png";
        localStorage.setItem("theme", isLight ? "light" : "dark");
    };

    window.abrirMenu = function () {
        document.getElementById("menu").classList.toggle("active");
    };
})();
</script>