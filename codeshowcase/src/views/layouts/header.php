<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeShowcase</title>
    <link rel="icon" href="/public/assets/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php

$links = [
    "Home" => "#",
    "Sobre" => "#",
    "Serviços" => "#",
    "Contato" => "#"
];

?>

<nav class="navbar">
    <div style="display: flex; align-items: center;">
        <img src="/public/assets/favicon.ico" class="logo" alt="Logo">
    </div>

    <div class="nav-links" id="menu">
        <a href="index.php">Home</a>
        <a href="#">Sobre</a>
        <a href="produtos.php">Produtos</a>
        <a href="contatos.php">Contato</a>
    </div>

    <div class="navbar-buttons">

        <button id="theme-btn" class="theme-btn" onclick="trocarTema()">
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

    const btn = document.getElementById("themeBtn");
    const icon = document.getElementById("themeIcon");

    if (document.body.classList.contains("dark-mode")) {
        icon.src = "/assets/sun.png";
        localStorage.setItem("theme", "dark");
    } else {
        icon.src = "/assert/moon.png";
        localStorage.setItem("theme", "light");
    }
}

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
    icon.src = "/assets/sun.png";
}
</script>