<?php
include_once 'BaseLayout.php';

$links = [
    "Home" => "#",
    "Recursos" => "#",
    "Projetos" => "#",
    "Tutoriais" => "#"
];

?>

<nav class="navbar">
    <div style="display: flex; align-items: center;">
        <img src="/assets/favicon.ico" class="logo" alt="Logo">
    </div>

    <div class="nav-links" id="menu">
        <a href="/home">Home</a>
        <a href="#">Recursos</a>
        <a href="produtos.php">Projetos</a>
        <a href="contatos.php">Tutoriais</a>
    </div>

    <div class="cadastro-login">
        <a href="/cadastro">Cadastrar</a>
        <a href="login.php">Login</a>
    </div>

    <div class="navbar-buttons">

        <button id="themeBtn" class="theme-btn" onclick="trocarTema()">
            <img id="themeIcon" src="/assets/moon.png" alt="Tema">
        </button>

        <button class="menu-btn" onclick="abrirMenu()">
            ☰
        </button>

    </div>

</nav>

<script>

function abrirMenu() {

    const menu = document.getElementById("menu");

    menu.classList.toggle("active");
}

function trocarTema() {

    document.body.classList.toggle("dark");

    const icon = document.getElementById("themeIcon");

    if (document.body.classList.contains("dark")) {
        icon.src = "/assets/sun.png";
        localStorage.setItem("theme", "dark");
    } else {
        icon.src = "/assets/moon.png";
        localStorage.setItem("theme", "light");
    }
}

const icon = document.getElementById("themeIcon");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    icon.src = "/assets/sun.png";
}
</script>