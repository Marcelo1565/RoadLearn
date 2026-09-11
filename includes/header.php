<?php
$base = base_path();
$title = $title ?? 'RoadLearn';
$active = $active ?? '';
?><!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="RoadLearn: roadmaps de aprendizagem para estudar com mais intenção e menos distração.">
    <title><?= e(page_title($title)) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>
<body>
<a class="skip-link" href="#main-content">Ir para o conteúdo</a>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= e(home_url()) ?>" aria-label="RoadLearn, página inicial">
            <span class="brand-mark">R</span><span>road<span class="brand-accent">learn</span></span>
        </a>
        <nav class="main-nav" id="main-nav" aria-label="Navegação principal">
            <a class="<?= $active === 'inicio' ? 'is-active' : '' ?>" href="<?= e(home_url()) ?>">Início</a>
            <a class="<?= $active === 'catalogo' ? 'is-active' : '' ?>" href="<?= e(catalog_url()) ?>">Explorar roadmaps</a>
            <a href="<?= e(home_url()) ?>#como-funciona">Como funciona</a>
        </nav>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-nav">Menu</button>
    </div>
</header>
<main id="main-content">
