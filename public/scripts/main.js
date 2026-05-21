/**
 * Santa Cruz — animaciones (sin cursor custom)
 *   GSAP + ScrollTrigger: hero stagger, parallax, contadores, nav shrink
 *   Swiper: carrusel proyectos destacados
 *   AOS: fade-in genéricos
 *   Menú móvil
 */
(function () {
  'use strict';

  // ─── Loader inicial ───────────────────────────────────────────────
  window.addEventListener('load', () => {
    const loader = document.getElementById('pageLoader');
    if (loader) {
      setTimeout(() => loader.classList.add('is-hidden'), 250);
      setTimeout(() => loader.remove(), 900);
    }
  });

  // ─── AOS ──────────────────────────────────────────────────────────
  if (window.AOS) {
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 60,
    });
  }

  // ─── GSAP + ScrollTrigger ─────────────────────────────────────────
  if (window.gsap && window.ScrollTrigger) {
    gsap.registerPlugin(ScrollTrigger);

    // Hero: palabras escalonadas
    gsap.set('.hero-title .word > span', { y: '110%' });
    gsap.to('.hero-title .word > span', {
      y: '0%',
      duration: 1.1,
      ease: 'power4.out',
      stagger: 0.09,
      delay: 0.2,
    });
    gsap.from('.hero-sub', {
      y: 30, opacity: 0, duration: 1, delay: 0.9, ease: 'power3.out',
    });
    gsap.from('.hero-cta > *', {
      y: 30, opacity: 0, duration: 0.9, delay: 1.1, stagger: 0.1, ease: 'power3.out',
    });

    // Parallax del hero
    if (document.querySelector('.hero-bg img')) {
      gsap.to('.hero-bg img', {
        yPercent: 20,
        ease: 'none',
        scrollTrigger: {
          trigger: '.hero',
          start: 'top top',
          end: 'bottom top',
          scrub: true,
        },
      });
    }

    // Contadores animados
    document.querySelectorAll('.stat').forEach((el) => {
      const target = parseInt(el.dataset.target || '0', 10);
      const suffix = el.dataset.suffix || '';
      ScrollTrigger.create({
        trigger: el,
        start: 'top 85%',
        once: true,
        onEnter: () => {
          const obj = { n: 0 };
          gsap.to(obj, {
            n: target,
            duration: 2,
            ease: 'power2.out',
            onUpdate: () => {
              el.textContent = Math.round(obj.n).toLocaleString('es-PE') + suffix;
            },
          });
        },
      });
    });

    // Nav: cambia look al hacer scroll (clase is-scrolled definida en Nav.astro)
    const nav = document.getElementById('nav');
    if (nav) {
      const toggleNavScrolled = () => {
        if (window.scrollY > 80) nav.classList.add('is-scrolled');
        else nav.classList.remove('is-scrolled');
      };
      toggleNavScrolled();
      window.addEventListener('scroll', toggleNavScrolled, { passive: true });
    }

    // Transición entrada del main
    gsap.from('main', { opacity: 0, duration: 0.6, ease: 'power2.out' });
  }

  // ─── Swiper proyectos destacados ──────────────────────────────────
  if (window.Swiper && document.querySelector('.projectsSwiper')) {
    new Swiper('.projectsSwiper', {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      speed: 900,
      autoplay: { delay: 4500, disableOnInteraction: false },
      grabCursor: true,
      pagination: { el: '.projectsSwiper .swiper-pagination', clickable: true },
      navigation: {
        nextEl: '.projectsSwiper .swiper-button-next',
        prevEl: '.projectsSwiper .swiper-button-prev',
      },
      breakpoints: {
        768:  { slidesPerView: 1.4 },
        1100: { slidesPerView: 1.8 },
      },
    });
  }

  // ─── Menú móvil ───────────────────────────────────────────────────
  const navToggle = document.getElementById('navToggle');
  const navMobile = document.getElementById('navMobile');
  if (navToggle && navMobile) {
    navToggle.addEventListener('click', () => navMobile.classList.toggle('hidden'));
    navMobile.querySelectorAll('a').forEach((a) =>
      a.addEventListener('click', () => navMobile.classList.add('hidden'))
    );
  }

  // ─── Botones magnetic (hover sutil que sigue al cursor) ───────────
  document.querySelectorAll('.btn-primary, .btn-shine').forEach((btn) => {
    const reset = () => { btn.style.transform = ''; };
    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top  - rect.height / 2;
      btn.style.transform = `translate(${x * 0.15}px, ${y * 0.2}px)`;
    });
    btn.addEventListener('mouseleave', reset);
  });

})();
