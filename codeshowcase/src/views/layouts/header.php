<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeShowcase</title>
    <link rel="stylesheet" href="/codeshowcase/public/css/style.css">
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
        <img src="/codeshowcase/public/assets/favicon.ico" class="logo" alt="Logo">
    </div>

    <div class="nav-links" id="menu">
        <a href="index.php">Home</a>
        <a href="#">Sobre</a>
        <a href="produtos.php">Produtos</a>
        <a href="contatos.php">Contato</a>
    </div>

    <div class="navbar-buttons">

        <button id="themeBtn" class="theme-btn" onclick="trocarTema()">
            <img id="themeIcon" src="/codeshowcase/public/assets/moon.png" alt="Tema">
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
        icon.src = "/codeshowcase/public/assets/sun.png";
        localStorage.setItem("theme", "dark");
    } else {
        icon.src = "/codeshowcase/public/assets/moon.png";
        localStorage.setItem("theme", "light");
    }
}

const icon = document.getElementById("themeIcon");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    icon.src = "/codeshowcase/public/assets/sun.png";
}
</script>