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
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (window.matchMedia('(max-width: 720px)').matches) return;

    const heroes = document.querySelectorAll('[data-parallax]');
    if (!heroes.length) return;

    let ticking = false;
    const onScroll = () => {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(() => {
        const y = window.scrollY;
        heroes.forEach((img) => {
          img.style.transform = `translate3d(0, ${y * 0.18}px, 0) scale(1.05)`;
        });
        ticking = false;
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

    const mq = window.matchMedia('(max-width: 1100px)');
    const setOpen = (open) => {
      const shouldOpen = Boolean(open) && mq.matches;
      nav.classList.toggle('is-open', shouldOpen);
      toggle.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
      toggle.setAttribute('aria-label', shouldOpen ? 'Close menu' : 'Open menu');
      document.body.classList.toggle('nav-open', shouldOpen);
    };

    on(toggle, 'click', () => setOpen(!nav.classList.contains('is-open')));
    nav.querySelectorAll('a').forEach((link) => {
      on(link, 'click', () => setOpen(false));
    });
    on(document, 'keydown', (event) => {
      if (event.key === 'Escape') setOpen(false);
    });
    const onChange = () => setOpen(false);
    if (mq.addEventListener) {
      mq.addEventListener('change', onChange);
      cleanups.push(() => mq.removeEventListener('change', onChange));
    } else {
      mq.addListener(onChange);
      cleanups.push(() => mq.removeListener(onChange));
    }
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
