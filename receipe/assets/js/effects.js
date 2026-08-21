/**
 * Ruchi Effects Hub — highly updateable JS effects
 * -------------------------------------------------
 * Toggle any effect from window.RUCHI.effects in footer.php
 * or call RuchiEffects.update({ scrollReveal: false }) at runtime.
 */
(function () {
  const defaults = {
    scrollReveal: true,
    hoverLift: true,
    stickyPanel: true,
    parallaxHero: true,
    toasts: true,
    navMobile: true
  };

  const state = Object.assign({}, defaults, (window.RUCHI && window.RUCHI.effects) || {});
  const cleanups = [];

  function on(el, event, handler, options) {
    if (!el) return;
    el.addEventListener(event, handler, options);
    cleanups.push(() => el.removeEventListener(event, handler, options));
  }

  function initScrollReveal() {
    if (!state.scrollReveal || !('IntersectionObserver' in window)) {
      document.querySelectorAll('[data-reveal]').forEach((el) => el.classList.add('is-visible'));
      return;
    }
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    document.querySelectorAll('[data-reveal]').forEach((el) => io.observe(el));
    cleanups.push(() => io.disconnect());
  }

  function initParallaxHero() {
    if (!state.parallaxHero) return;
    const heroes = document.querySelectorAll('[data-parallax]');
    if (!heroes.length) return;

    const onScroll = () => {
      const y = window.scrollY;
      heroes.forEach((img) => {
        img.style.transform = `translate3d(0, ${y * 0.22}px, 0) scale(1.05)`;
      });
    };
    on(window, 'scroll', onScroll, { passive: true });
    onScroll();
  }

  function initStickyPanel() {
    if (!state.stickyPanel) return;
    // CSS handles sticky; this adds a soft shadow when stuck
    const panel = document.querySelector('[data-sticky-panel]');
    if (!panel) return;
    const sentinel = document.createElement('div');
    panel.parentNode.insertBefore(sentinel, panel);
    const io = new IntersectionObserver(([entry]) => {
      panel.classList.toggle('is-stuck', !entry.isIntersecting);
    });
    io.observe(sentinel);
    cleanups.push(() => io.disconnect());
  }

  function initToasts() {
    if (!state.toasts) return;
    document.querySelectorAll('[data-toast]').forEach((toast) => {
      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-8px)';
        setTimeout(() => toast.remove(), 300);
      }, 3200);
    });
  }

  function initNav() {
    if (!state.navMobile) return;
    const toggle = document.querySelector('[data-nav-toggle]');
    const nav = document.querySelector('[data-site-nav]');
    if (!toggle || !nav) return;
    on(toggle, 'click', () => nav.classList.toggle('is-open'));
  }

  function initHoverLift() {
    if (!state.hoverLift) return;
    // Pure CSS; keep hook for future JS-driven variants
  }

  function boot() {
    initScrollReveal();
    initParallaxHero();
    initStickyPanel();
    initToasts();
    initNav();
    initHoverLift();
  }

  function destroy() {
    while (cleanups.length) {
      const fn = cleanups.pop();
      try { fn(); } catch (_) { /* ignore */ }
    }
  }

  window.RuchiEffects = {
    state,
    update(partial) {
      Object.assign(state, partial || {});
      destroy();
      boot();
    },
    destroy,
    boot
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
