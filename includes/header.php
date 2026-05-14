<?php
require_once __DIR__ . '/data.php';
$site = site_data();
$page_title = $page_title ?? ($site['name'] ?? 'Constructora');
$page_desc  = $page_desc  ?? ($site['tagline'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?= e($page_desc) ?>" />
  <meta name="theme-color" content="#0b1220" />

  <title><?= e($page_title) ?></title>

  <link rel="icon" type="image/svg+xml" href="<?= asset('assets/img/favicon.svg') ?>" />

  <!-- Fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind compilado -->
  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

  <!-- OpenGraph básico -->
  <meta property="og:title"       content="<?= e($page_title) ?>">
  <meta property="og:description" content="<?= e($page_desc) ?>">
  <meta property="og:type"        content="website">
  <?php if (!empty($site['hero_image'])): ?>
    <meta property="og:image" content="<?= e($site['hero_image']) ?>">
  <?php endif; ?>
</head>
<body class="has-cursor">

  <!-- Loader inicial -->
  <div class="page-loader" id="pageLoader">
    <span class="bar"></span><span class="bar"></span><span class="bar"></span><span class="bar"></span>
  </div>

  <!-- Cursor custom (solo desktop, lo añade JS si corresponde) -->
  <div class="cursor-dot"  id="cursorDot"></div>
  <div class="cursor-ring" id="cursorRing"></div>

  <?php include __DIR__ . '/nav.php'; ?>

  <main id="main">
