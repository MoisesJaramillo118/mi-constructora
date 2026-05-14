<?php
require_once __DIR__ . '/includes/data.php';
$site = site_data();
$page_title = 'Contacto — ' . ($site['name'] ?? 'Constructora');
$page_desc  = 'Solicita una cotización o conversemos sobre tu proyecto.';

$status = $_GET['status'] ?? '';
$errors_q = isset($_GET['err']) ? array_filter(array_map('trim', explode('|', $_GET['err']))) : [];

include __DIR__ . '/includes/header.php';
?>

<section class="relative pt-44 pb-20 bg-ink-900 text-white overflow-hidden">
  <div class="absolute inset-0 -z-10 opacity-30">
    <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1920&q=80" alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-ink-900 via-ink-900/70 to-ink-900"></div>
  </div>
  <div class="container-x text-center">
    <span class="eyebrow text-brand-400" data-aos="fade-up">Contacto</span>
    <h1 class="h-section text-balance max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
      Hablemos de tu próxima obra
    </h1>
  </div>
</section>

<section class="py-24">
  <div class="container-x grid grid-cols-1 lg:grid-cols-5 gap-12">

    <!-- Datos -->
    <aside class="lg:col-span-2 space-y-7" data-aos="fade-right">
      <div>
        <h3 class="font-display font-bold text-2xl text-ink-900">Contáctanos directamente</h3>
        <p class="mt-2 text-ink-700/70">Respondemos en menos de 24h hábiles.</p>
      </div>

      <?php if (!empty($site['phone'])): ?>
        <a href="tel:<?= e($site['phone']) ?>" class="block group">
          <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-200 hover:border-brand-500 hover:shadow-md transition">
            <span class="w-11 h-11 rounded-xl bg-brand-100 text-brand-600 inline-flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.86 19.86 0 0 1 2.06 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.27-1.34a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </span>
            <div>
              <div class="text-xs uppercase tracking-[0.2em] text-ink-700/60">Teléfono</div>
              <div class="font-semibold text-ink-900 text-lg"><?= e($site['phone']) ?></div>
            </div>
          </div>
        </a>
      <?php endif; ?>

      <?php if (!empty($site['email'])): ?>
        <a href="mailto:<?= e($site['email']) ?>" class="block group">
          <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-200 hover:border-brand-500 hover:shadow-md transition">
            <span class="w-11 h-11 rounded-xl bg-brand-100 text-brand-600 inline-flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 4h16v16H4z"/><path d="M4 6l8 7 8-7"/></svg>
            </span>
            <div>
              <div class="text-xs uppercase tracking-[0.2em] text-ink-700/60">Correo</div>
              <div class="font-semibold text-ink-900 text-lg break-all"><?= e($site['email']) ?></div>
            </div>
          </div>
        </a>
      <?php endif; ?>

      <?php if (!empty($site['whatsapp'])): ?>
        <a href="<?= e(wa_link($site['whatsapp'], $site['whatsapp_message'] ?? 'Hola, vengo desde la web')) ?>"
           target="_blank" rel="noopener" class="block group">
          <div class="flex items-start gap-4 p-5 rounded-xl border border-slate-200 hover:border-green-500 hover:shadow-md transition">
            <span class="w-11 h-11 rounded-xl bg-green-100 text-green-600 inline-flex items-center justify-center group-hover:bg-green-500 group-hover:text-white transition">
              <svg width="22" height="22" viewBox="0 0 32 32" fill="currentColor"><path d="M16 4C9.9 4 5 8.9 5 15c0 2.3.7 4.5 2 6.4L5.5 27l5.7-1.6c1.8 1 3.8 1.5 5.8 1.5 6.1 0 11-4.9 11-11S22.1 4 16 4zm0 20a8.99 8.99 0 0 1-4.7-1.3l-.3-.2-3.4 1 1-3.3-.2-.3A9 9 0 1 1 16 24z"/></svg>
            </span>
            <div>
              <div class="text-xs uppercase tracking-[0.2em] text-ink-700/60">WhatsApp</div>
              <div class="font-semibold text-ink-900 text-lg">Escríbenos al chat</div>
            </div>
          </div>
        </a>
      <?php endif; ?>

      <?php if (!empty($site['address'])): ?>
        <div class="p-5 rounded-xl bg-slate-50">
          <div class="text-xs uppercase tracking-[0.2em] text-ink-700/60 mb-1">Dirección</div>
          <div class="text-ink-900 font-medium"><?= e($site['address']) ?></div>
        </div>
      <?php endif; ?>
    </aside>

    <!-- Formulario -->
    <div class="lg:col-span-3" data-aos="fade-left">
      <?php if ($status === 'ok'): ?>
        <div class="rounded-xl border border-green-300 bg-green-50 text-green-800 p-6 mb-8">
          <div class="font-semibold text-lg">¡Mensaje enviado!</div>
          <p class="mt-1 text-sm">Gracias por escribirnos. Te responderemos a la brevedad.</p>
        </div>
      <?php elseif ($status === 'err' && !empty($errors_q)): ?>
        <div class="rounded-xl border border-red-300 bg-red-50 text-red-800 p-6 mb-8">
          <div class="font-semibold">Revisa los datos del formulario:</div>
          <ul class="mt-2 list-disc pl-5 text-sm space-y-1">
            <?php foreach ($errors_q as $msg): ?><li><?= e($msg) ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="/enviar.php" method="POST" class="space-y-5 bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">

        <!-- honeypot anti-bot, vacío para humanos -->
        <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <label class="block">
            <span class="text-xs uppercase tracking-[0.2em] text-ink-700/70 font-semibold">Nombre*</span>
            <input type="text" name="name" required maxlength="120"
                   class="mt-2 w-full rounded-lg border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none px-4 py-3 transition">
          </label>
          <label class="block">
            <span class="text-xs uppercase tracking-[0.2em] text-ink-700/70 font-semibold">Teléfono</span>
            <input type="tel" name="phone" maxlength="40"
                   class="mt-2 w-full rounded-lg border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none px-4 py-3 transition">
          </label>
        </div>

        <label class="block">
          <span class="text-xs uppercase tracking-[0.2em] text-ink-700/70 font-semibold">Email*</span>
          <input type="email" name="email" required maxlength="200"
                 class="mt-2 w-full rounded-lg border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none px-4 py-3 transition">
        </label>

        <label class="block">
          <span class="text-xs uppercase tracking-[0.2em] text-ink-700/70 font-semibold">Servicio de interés</span>
          <select name="service" class="mt-2 w-full rounded-lg border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none px-4 py-3 bg-white transition">
            <option value="">Selecciona uno (opcional)</option>
            <?php foreach (services() as $s): ?>
              <option value="<?= e($s['title']) ?>"><?= e($s['title']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>

        <label class="block">
          <span class="text-xs uppercase tracking-[0.2em] text-ink-700/70 font-semibold">Cuéntanos tu proyecto*</span>
          <textarea name="message" required minlength="10" maxlength="2000" rows="5"
                    class="mt-2 w-full rounded-lg border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none px-4 py-3 transition resize-y"
                    placeholder="Ubicación, metros cuadrados, tiempo estimado, etc."></textarea>
        </label>

        <button type="submit" class="btn-primary w-full md:w-auto">
          Enviar mensaje
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </button>

        <p class="text-xs text-ink-700/50">* campos obligatorios. Solo usamos tu información para responder tu consulta.</p>
      </form>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
