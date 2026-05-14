<?php
require_once __DIR__ . '/includes/data.php';
$site = site_data();
$page_title = ($site['name'] ?? 'Constructora') . ' — ' . ($site['tagline'] ?? '');
$page_desc  = $site['tagline'] ?? '';

$featured = projects(true);
$all_services = services();
$all_stats = stats();

// Convierte el título del hero en palabras envueltas para animarlas con stagger.
$hero_words = preg_split('/\s+/', trim($site['hero_title'] ?? 'Construimos lo que imaginas'));

include __DIR__ . '/includes/header.php';
?>

<!-- ========== HERO ========== -->
<section class="hero relative h-screen min-h-[640px] flex items-center overflow-hidden">

  <div class="hero-bg absolute inset-0 -z-10 will-change-transform">
    <img src="<?= e($site['hero_image'] ?? '') ?>" alt=""
         class="w-full h-[120%] object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-ink-900/70 via-ink-900/55 to-ink-900/85"></div>
  </div>

  <div class="container-x relative w-full">
    <span class="eyebrow text-brand-400" data-aos="fade-up">Constructora · Lima · Perú</span>

    <h1 class="hero-title text-white text-5xl md:text-7xl lg:text-8xl font-display font-bold leading-[1.05] max-w-5xl text-balance">
      <?php foreach ($hero_words as $i => $w): ?>
        <span class="word inline-block overflow-hidden">
          <span class="inline-block <?= $i === count($hero_words) - 1 ? 'text-brand-400 italic' : '' ?>"><?= e($w) ?></span>
        </span>
      <?php endforeach; ?>
    </h1>

    <p class="hero-sub mt-7 text-white/80 text-lg md:text-xl max-w-2xl leading-relaxed">
      <?= nl2br(e($site['hero_subtitle'] ?? '')) ?>
    </p>

    <div class="hero-cta mt-10 flex flex-wrap gap-4">
      <a href="/proyectos" class="btn-primary">Ver nuestros proyectos
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </a>
      <a href="/contacto" class="btn-ghost">Solicitar cotización</a>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60 text-xs uppercase tracking-[0.4em] flex flex-col items-center gap-2">
      <span>Desliza</span>
      <span class="w-px h-10 bg-gradient-to-b from-white/60 to-transparent animate-pulse"></span>
    </div>
  </div>
</section>

<!-- ========== ESTADÍSTICAS ========== -->
<section class="bg-ink-900 text-white py-20 -mt-1">
  <div class="container-x grid grid-cols-2 md:grid-cols-4 gap-10">
    <?php foreach ($all_stats as $s): ?>
      <div class="text-center md:text-left" data-aos="fade-up" data-aos-delay="<?= 100 * array_search($s, $all_stats, true) ?>">
        <div class="stat font-display font-bold text-5xl md:text-6xl text-brand-400"
             data-target="<?= (int)$s['value'] ?>"
             data-suffix="<?= e($s['suffix'] ?? '') ?>">
          0<?= e($s['suffix'] ?? '') ?>
        </div>
        <div class="mt-3 text-white/70 uppercase tracking-[0.2em] text-xs"><?= e($s['label']) ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ========== QUIÉNES SOMOS ========== -->
<section id="nosotros" class="py-28">
  <div class="container-x grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

    <div data-aos="fade-right">
      <div class="relative">
        <img src="<?= e($site['about_image'] ?? '') ?>" alt=""
             class="rounded-2xl shadow-2xl w-full aspect-[4/5] object-cover">
        <div class="hidden md:block absolute -bottom-8 -right-8 bg-brand-600 text-white p-7 rounded-2xl shadow-xl max-w-[230px]">
          <div class="font-display font-bold text-4xl">15+</div>
          <div class="text-sm mt-1 opacity-90">años transformando ideas en obras</div>
        </div>
      </div>
    </div>

    <div data-aos="fade-left">
      <span class="eyebrow">Quiénes somos</span>
      <h2 class="h-section text-ink-900">
        <?= e($site['about_title'] ?? 'Una constructora que combina experiencia y modernidad') ?>
      </h2>
      <div class="mt-7 text-ink-700/80 text-lg leading-relaxed space-y-4">
        <?php foreach (explode("\n\n", $site['about_text'] ?? '') as $p): ?>
          <p><?= nl2br(e(trim($p))) ?></p>
        <?php endforeach; ?>
      </div>
      <a href="/contacto" class="btn-dark mt-9">Conversemos sobre tu proyecto</a>
    </div>

  </div>
</section>

<!-- ========== SERVICIOS ========== -->
<section class="bg-slate-50 py-28">
  <div class="container-x">
    <div class="max-w-2xl mx-auto text-center mb-16" data-aos="fade-up">
      <span class="eyebrow">Servicios</span>
      <h2 class="h-section text-ink-900">Todo lo que necesitas, bajo un mismo techo</h2>
      <p class="mt-5 text-ink-700/70 text-lg">Desde el primer boceto hasta la entrega de llaves.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
      <?php foreach ($all_services as $i => $s): ?>
        <div class="card p-8 group" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
          <div class="w-14 h-14 rounded-2xl bg-brand-100 text-brand-600 inline-flex items-center justify-center mb-5 group-hover:bg-brand-600 group-hover:text-white transition">
            <?= icon($s['icon']) ?>
          </div>
          <h3 class="font-display font-bold text-xl text-ink-900"><?= e($s['title']) ?></h3>
          <p class="mt-3 text-ink-700/70 leading-relaxed text-sm"><?= e($s['description']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========== CARRUSEL DE PROYECTOS ========== -->
<section class="bg-ink-900 py-28 overflow-hidden">
  <div class="container-x mb-12">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6" data-aos="fade-up">
      <div>
        <span class="eyebrow text-brand-400">Proyectos destacados</span>
        <h2 class="h-section text-white">Obras que hablan por sí solas</h2>
      </div>
      <a href="/proyectos" class="btn-ghost self-start md:self-auto">Ver todos los proyectos</a>
    </div>
  </div>

  <div class="swiper projectsSwiper" data-aos="fade-up">
    <div class="swiper-wrapper">
      <?php foreach ($featured as $p): ?>
        <div class="swiper-slide px-4">
          <div class="relative group rounded-3xl overflow-hidden aspect-[16/10] shadow-2xl">
            <img src="<?= e($p['image']) ?>" alt="<?= e($p['title']) ?>"
                 class="w-full h-full object-cover transition duration-[1500ms] group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-ink-900 via-ink-900/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
              <div class="text-xs uppercase tracking-[0.3em] text-brand-400 mb-2">
                <?= e($p['year']) ?> · <?= e($p['location']) ?>
              </div>
              <h3 class="font-display font-bold text-3xl md:text-4xl"><?= e($p['title']) ?></h3>
              <p class="mt-3 max-w-xl text-white/80 text-sm md:text-base leading-relaxed">
                <?= e($p['description']) ?>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="swiper-pagination !relative !bottom-0 mt-10"></div>
    <div class="hidden md:block">
      <div class="swiper-button-prev !left-2"></div>
      <div class="swiper-button-next !right-2"></div>
    </div>
  </div>
</section>

<!-- ========== CTA FINAL ========== -->
<section class="relative py-24 overflow-hidden">
  <div class="absolute inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&fit=crop&w=1920&q=80"
         alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-ink-900/85"></div>
  </div>

  <div class="container-x text-center text-white" data-aos="zoom-in">
    <h2 class="h-section max-w-3xl mx-auto">
      <?= e($site['cta_title'] ?? '¿Tienes un terreno y una idea?') ?>
    </h2>
    <p class="mt-6 text-white/80 text-lg max-w-xl mx-auto">
      <?= e($site['cta_subtitle'] ?? 'Solicita una cotización sin compromiso.') ?>
    </p>
    <a href="/contacto" class="btn-shine btn text-white mt-10">
      Cotiza tu obra ahora
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
    </a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
