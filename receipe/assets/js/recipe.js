/**
 * Recipe page interactions — servings math, timers, engagement
 */
(function () {
  const root = document.querySelector('[data-recipe]');
  if (!root) return;

  const baselineServings = Number(root.dataset.servings || 4);
  let currentServings = baselineServings;
  const servingsLabel = document.querySelector('[data-servings-value]');
  const qtyNodes = document.querySelectorAll('[data-base-qty]');

  function renderQuantities() {
    const factor = currentServings / baselineServings;
    qtyNodes.forEach((node) => {
      const base = Number(node.dataset.baseQty);
      const next = base * factor;
      node.textContent = Number.isInteger(next)
        ? String(next)
        : String(Math.round(next * 100) / 100).replace(/\.00$/, '');
    });
    if (servingsLabel) servingsLabel.textContent = String(currentServings);
  }

  document.querySelectorAll('[data-servings-btn]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const delta = Number(btn.dataset.servingsBtn);
      currentServings = Math.max(1, Math.min(20, currentServings + delta));
      renderQuantities();
    });
  });

  document.querySelectorAll('[data-ingredient-check]').forEach((box) => {
    box.addEventListener('change', () => {
      box.closest('li')?.classList.toggle('is-checked', box.checked);
    });
  });

  // Step timers
  document.querySelectorAll('[data-timer]').forEach((wrap) => {
    const total = Number(wrap.dataset.timer || 0);
    const display = wrap.querySelector('[data-timer-display]');
    const startBtn = wrap.querySelector('[data-timer-start]');
    const resetBtn = wrap.querySelector('[data-timer-reset]');
    let remaining = total;
    let interval = null;

    function paint() {
      const m = Math.floor(remaining / 60);
      const s = remaining % 60;
      if (display) display.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
    }

    function chime() {
      try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const o = ctx.createOscillator();
        const g = ctx.createGain();
        o.connect(g); g.connect(ctx.destination);
        o.frequency.value = 880;
        g.gain.value = 0.05;
        o.start();
        setTimeout(() => { o.stop(); ctx.close(); }, 450);
        if (navigator.vibrate) navigator.vibrate([120, 60, 120]);
      } catch (_) { /* silent */ }
    }

    paint();
    startBtn?.addEventListener('click', () => {
      if (interval) return;
      interval = setInterval(() => {
        remaining -= 1;
        paint();
        if (remaining <= 0) {
          clearInterval(interval);
          interval = null;
          remaining = 0;
          paint();
          chime();
        }
      }, 1000);
    });
    resetBtn?.addEventListener('click', () => {
      if (interval) clearInterval(interval);
      interval = null;
      remaining = total;
      paint();
    });
  });

  // Engagement actions
  async function postAction(path, body) {
    const res = await fetch((window.RUCHI?.appUrl || '') + '/' + path, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: JSON.stringify(body)
    });
    return res.json();
  }

  document.querySelectorAll('[data-action]').forEach((btn) => {
    btn.addEventListener('click', async () => {
      const action = btn.dataset.action;
      const recipeId = Number(root.dataset.recipeId);
      btn.classList.add('is-active');
      try {
        const data = await postAction('api/' + action + '.php', { recipe_id: recipeId });
        if (data.message) {
          const toast = document.createElement('div');
          toast.className = 'toast toast--' + (data.ok ? 'success' : 'error');
          toast.textContent = data.message;
          document.body.appendChild(toast);
          setTimeout(() => toast.remove(), 2800);
        }
        if (action === 'cooked' && data.ok) {
          const el = document.querySelector('[data-cooked-count]');
          if (el && typeof data.cooked_count !== 'undefined') el.textContent = data.cooked_count;
        }
        if (!data.ok) btn.classList.remove('is-active');
      } catch (err) {
        btn.classList.remove('is-active');
      }
    });
  });

  // Like / save micro-interaction
  document.querySelectorAll('[data-pop]').forEach((btn) => {
    btn.addEventListener('click', () => {
      btn.animate(
        [{ transform: 'scale(1)' }, { transform: 'scale(1.12)' }, { transform: 'scale(1)' }],
        { duration: 280, easing: 'ease-out' }
      );
    });
  });

  // Short video: autoplay muted when scrolled into view
  const video = document.querySelector('[data-recipe-video]');
  if (video && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            video.play().catch(() => {});
          } else {
            video.pause();
          }
        });
      },
      { threshold: 0.45 }
    );
    io.observe(video);
    document.querySelector('[data-unmute-video]')?.addEventListener('click', () => {
      video.muted = !video.muted;
      const btn = document.querySelector('[data-unmute-video]');
      if (btn) btn.textContent = video.muted ? 'Tap to unmute' : 'Mute';
      video.play().catch(() => {});
    });
  }
})();
