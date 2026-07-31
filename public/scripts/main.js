/**
 * Interacciones globales ligeras:
 * navegacion, menu movil y revelados al hacer scroll.
 */
(function () {
  'use strict';

  const root = document.documentElement;
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!reduceMotion) {
    root.classList.add('motion-ready');
  }

  const nav = document.getElementById('nav');
  const navToggle = document.getElementById('navToggle');
  const navMobile = document.getElementById('navMobile');

  const updateNav = () => {
    nav?.classList.toggle('is-scrolled', window.scrollY > 32);
  };

  updateNav();
  window.addEventListener('scroll', updateNav, { passive: true });

  const setMenu = (open) => {
    if (!navToggle || !navMobile) return;
    navToggle.setAttribute('aria-expanded', String(open));
    navToggle.setAttribute('aria-label', open ? 'Cerrar menu' : 'Abrir menu');
    navToggle.classList.toggle('is-open', open);
    navMobile.classList.toggle('hidden', !open);
    document.body.classList.toggle('menu-open', open);
  };

  navToggle?.addEventListener('click', () => {
    setMenu(navToggle.getAttribute('aria-expanded') !== 'true');
  });

  navMobile?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setMenu(false));
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') setMenu(false);
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) setMenu(false);
  });

  const animated = Array.from(document.querySelectorAll('[data-aos]'));

  animated.forEach((element) => {
    const delay = Number(element.getAttribute('data-aos-delay') || 0);
    element.style.transitionDelay = `${Math.min(delay, 240)}ms`;
  });

  if (reduceMotion || !('IntersectionObserver' in window)) {
    animated.forEach((element) => element.classList.add('is-visible'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    },
    {
      threshold: 0.12,
      rootMargin: '0px 0px -7% 0px',
    }
  );

  animated.forEach((element) => observer.observe(element));
})();
