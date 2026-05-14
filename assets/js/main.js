/**
 * Constructora — animaciones premium
 *  - GSAP + ScrollTrigger: hero stagger, parallax, contadores, nav shrink
 *  - Swiper: carrusel proyectos destacados
 *  - AOS: fade-in genéricos
 *  - Cursor custom (solo desktop con pointer fino)
 *  - Menú móvil
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

    // Hero: palabras aparecen escalonadas
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

    // Parallax del fondo del hero
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

    // Nav shrink al hacer scroll
    const nav = document.getElementById('nav');
    if (nav) {
      ScrollTrigger.create({
        start: 'top -80',
        end: 99999,
        onUpdate: (self) => {
          if (self.scroll() > 80) {
            nav.classList.add('bg-ink-900/90', 'backdrop-blur-md', 'shadow-lg', 'py-2');
            nav.classList.remove('py-5');
          } else {
            nav.classList.remove('bg-ink-900/90', 'backdrop-blur-md', 'shadow-lg', 'py-2');
            nav.classList.add('py-5');
          }
        },
      });
    }

    // Transición entrada del main
    gsap.from('main', { opacity: 0, duration: 0.6, ease: 'power2.out' });
  }

  // ─── Swiper carrusel de proyectos destacados ──────────────────────
  if (window.Swiper && document.querySelector('.projectsSwiper')) {
    new Swiper('.projectsSwiper', {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      speed: 900,
      autoplay: { delay: 4500, disableOnInteraction: false },
      effect: 'slide',
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

  // ─── Cursor custom (solo desktop con pointer fino) ────────────────
  const isFinePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  const dot  = document.getElementById('cursorDot');
  const ring = document.getElementById('cursorRing');

  if (isFinePointer && dot && ring) {
    const mouse = { x: 0, y: 0 };
    const ringPos = { x: 0, y: 0 };

    document.addEventListener('mousemove', (e) => {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
      dot.style.transform = `translate(${mouse.x}px, ${mouse.y}px) translate(-50%, -50%)`;
    });

    function animateRing() {
      ringPos.x += (mouse.x - ringPos.x) * 0.18;
      ringPos.y += (mouse.y - ringPos.y) * 0.18;
      ring.style.transform = `translate(${ringPos.x}px, ${ringPos.y}px) translate(-50%, -50%)`;
      requestAnimationFrame(animateRing);
    }
    animateRing();

    const interactive = 'a, button, [role="button"], input, textarea, select, label';
    document.querySelectorAll(interactive).forEach((el) => {
      el.addEventListener('mouseenter', () => ring.classList.add('is-hover'));
      el.addEventListener('mouseleave', () => ring.classList.remove('is-hover'));
    });
  } else {
    document.body.classList.remove('has-cursor');
    if (dot)  dot.remove();
    if (ring) ring.remove();
  }

})();
