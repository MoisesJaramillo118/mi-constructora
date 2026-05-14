<?php
require_once __DIR__ . '/includes/data.php';
http_response_code(404);
$site = site_data();
$page_title = '404 — Página no encontrada';
$page_desc  = 'La página que buscas no existe.';
include __DIR__ . '/includes/header.php';
?>

<section class="min-h-[80vh] flex items-center bg-ink-900 text-white">
  <div class="container-x text-center" data-aos="fade-up">
    <div class="font-display font-bold text-[140px] md:text-[220px] leading-none text-brand-500">404</div>
    <h1 class="h-section mt-4">Esta obra aún no se ha construido</h1>
    <p class="mt-6 text-white/70 max-w-md mx-auto">La página que buscas no existe o fue movida. Volvamos a terreno conocido.</p>
    <a href="/" class="btn-primary mt-10">Ir al inicio</a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
