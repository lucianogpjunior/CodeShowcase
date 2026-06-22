<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeShowcase</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<?php
$links = [
    "Home" => "#",
    "Recursos" => "#",
    "Projetos" => "#",
    "Tutoriais" => "#"
];

?>

<nav class="navbar">
    <div style="display: flex; align-items: center;">
        <img src="/public/assets/favicon.ico" class="logo" alt="Logo">
    </div>

    <div class="nav-links" id="menu">
        <a href="/../../index.php">Home</a>
        <a href="#">Recursos</a>
        <a href="produtos.php">Projetos</a>
        <a href="contatos.php">Tutoriais</a>
    </div>

    <div class="auth-links">
        <a href="src/views/layouts/cadastroUserView.php">Cadastrar</a>
        <a href="login.php">Login</a>
    </div>

    <div class="navbar-buttons">

        <button id="themeBtn" class="theme-btn" onclick="trocarTema()">
            <img id="themeIcon" src="/public/assets/moon.png" alt="Tema">
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
        icon.src = "/public/assets/sun.png";
        localStorage.setItem("theme", "dark");
    } else {
        icon.src = "/public/assets/moon.png";
        localStorage.setItem("theme", "light");
    }
}

const icon = document.getElementById("themeIcon");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    icon.src = "/public/assets/sun.png";
}
</script>