  </main>

<?php $site = $site ?? site_data(); ?>

<footer class="bg-ink-900 text-white pt-20 pb-10 mt-24">
  <div class="container-x grid grid-cols-1 md:grid-cols-4 gap-12">

    <div class="md:col-span-2">
      <div class="flex items-center gap-3 mb-5">
        <span class="inline-flex w-10 h-10 rounded-full bg-brand-600 items-center justify-center text-white font-display font-bold text-xl">
          <?= e(strtoupper(substr($site['name'] ?? 'C', 0, 1))) ?>
        </span>
        <span class="font-display font-bold text-2xl"><?= e($site['name'] ?? 'Constructora') ?></span>
      </div>
      <p class="text-white/70 max-w-md leading-relaxed">
        <?= e($site['tagline'] ?? 'Construyendo el futuro con calidad y compromiso.') ?>
      </p>
    </div>

    <div>
      <h4 class="uppercase tracking-[0.25em] text-xs text-brand-400 font-semibold mb-5">Contacto</h4>
      <ul class="space-y-3 text-white/80 text-sm">
        <?php if (!empty($site['phone'])): ?>
          <li><a href="tel:<?= e($site['phone']) ?>" class="hover:text-white">📞 <?= e($site['phone']) ?></a></li>
        <?php endif; ?>
        <?php if (!empty($site['email'])): ?>
          <li><a href="mailto:<?= e($site['email']) ?>" class="hover:text-white">✉️ <?= e($site['email']) ?></a></li>
        <?php endif; ?>
        <?php if (!empty($site['address'])): ?>
          <li>📍 <?= e($site['address']) ?></li>
        <?php endif; ?>
      </ul>
    </div>

    <div>
      <h4 class="uppercase tracking-[0.25em] text-xs text-brand-400 font-semibold mb-5">Redes</h4>
      <ul class="space-y-3 text-white/80 text-sm">
        <?php if (!empty($site['instagram'])): ?>
          <li><a href="<?= e($site['instagram']) ?>" target="_blank" rel="noopener" class="hover:text-white">Instagram</a></li>
        <?php endif; ?>
        <?php if (!empty($site['facebook'])): ?>
          <li><a href="<?= e($site['facebook']) ?>" target="_blank" rel="noopener" class="hover:text-white">Facebook</a></li>
        <?php endif; ?>
        <?php if (!empty($site['whatsapp'])): ?>
          <li><a href="<?= e(wa_link($site['whatsapp'], 'Hola, vengo desde la web.')) ?>" target="_blank" rel="noopener" class="hover:text-white">WhatsApp</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <div class="container-x mt-14 pt-6 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-white/50">
    <span>© <?= date('Y') ?> <?= e($site['name'] ?? 'Constructora') ?>. Todos los derechos reservados.</span>
    <span>Hecho con cuidado.</span>
  </div>
</footer>

<!-- Botón flotante de WhatsApp -->
<?php if (!empty($site['whatsapp'])): ?>
<a id="waFab"
   href="<?= e(wa_link($site['whatsapp'], $site['whatsapp_message'] ?? 'Hola, vengo desde la web y quisiera más información.')) ?>"
   target="_blank" rel="noopener"
   aria-label="Escríbenos por WhatsApp"
   class="fixed bottom-6 right-6 z-40 group">
  <span class="absolute inset-0 rounded-full bg-green-500/40 animate-ping"></span>
  <span class="relative inline-flex w-14 h-14 rounded-full bg-[#25D366] items-center justify-center shadow-2xl shadow-green-600/40 group-hover:scale-110 transition-transform">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="28" height="28" fill="white">
      <path d="M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.49-1.318.155-.358.155-.658.082-.787-.085-.13-.302-.215-.586-.358-.272-.144-1.514-.747-1.736-.832z"/>
      <path d="M16.04 4C9.965 4 5 8.967 5 15.04c0 2.293.7 4.547 2.014 6.456l-1.65 4.92 5.062-1.575a11.04 11.04 0 0 0 5.62 1.53h.004c6.075 0 11.04-4.965 11.04-11.04 0-2.94-1.147-5.7-3.224-7.777A10.974 10.974 0 0 0 16.04 4zm0 19.97a9.18 9.18 0 0 1-4.69-1.282l-.336-.2-3.476 1.082 1.105-3.387-.216-.348a9.16 9.16 0 0 1-1.4-4.872c0-5.06 4.117-9.18 9.18-9.18 2.45 0 4.756.957 6.49 2.692a9.07 9.07 0 0 1 2.692 6.49c0 5.06-4.117 9.18-9.18 9.18z"/>
    </svg>
  </span>
</a>
<?php endif; ?>

<!-- Librerías de animación -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="<?= asset('assets/js/main.js') ?>"></script>

</body>
</html>
