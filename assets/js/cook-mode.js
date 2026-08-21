/**
 * Cook Mode — full-screen step viewer with large tap targets
 */
(function () {
  const shell = document.querySelector('[data-cook]');
  if (!shell) return;

  const raw = document.getElementById('cook-steps-data');
  const steps = raw ? JSON.parse(raw.textContent || '[]') : [];
  let index = 0;

  const titleEl = shell.querySelector('[data-cook-title]');
  const textEl = shell.querySelector('[data-cook-text]');
  const metaEl = shell.querySelector('[data-cook-meta]');
  const barEl = shell.querySelector('[data-cook-bar]');
  const prevBtn = shell.querySelector('[data-cook-prev]');
  const nextBtn = shell.querySelector('[data-cook-next]');
  const timerWrap = shell.querySelector('[data-cook-timer]');

  let timerInterval = null;
  let remaining = 0;

  function format(sec) {
    const m = Math.floor(sec / 60);
    const s = sec % 60;
    return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
  }

  function clearTimer() {
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = null;
  }

  function render() {
    const step = steps[index];
    if (!step) return;
    titleEl.textContent = `Step ${step.step_number} of ${steps.length}`;
    textEl.textContent = step.instruction;
    const mins = step.timer_seconds ? Math.round(step.timer_seconds / 60) : 0;
    metaEl.textContent = step.timer_seconds
      ? `Suggested timer: ${mins} ${mins === 1 ? 'minute' : 'minutes'}`
      : 'No timer for this step';
    barEl.style.width = `${((index + 1) / steps.length) * 100}%`;
    prevBtn.disabled = index === 0;
    nextBtn.textContent = index === steps.length - 1 ? 'Finish' : 'Next step';

    clearTimer();
    if (step.timer_seconds) {
      remaining = Number(step.timer_seconds);
      timerWrap.hidden = false;
      timerWrap.querySelector('[data-cook-timer-display]').textContent = format(remaining);
    } else {
      timerWrap.hidden = true;
    }

    // Prefer wake lock while cooking
    if ('wakeLock' in navigator) {
      navigator.wakeLock.request('screen').catch(() => {});
    }
  }

  prevBtn.addEventListener('click', () => {
    if (index > 0) { index -= 1; render(); }
  });
  nextBtn.addEventListener('click', () => {
    if (index < steps.length - 1) {
      index += 1;
      render();
    } else {
      window.location.href = shell.dataset.recipeUrl;
    }
  });

  timerWrap.querySelector('[data-cook-timer-start]')?.addEventListener('click', () => {
    if (timerInterval) return;
    const display = timerWrap.querySelector('[data-cook-timer-display]');
    timerInterval = setInterval(() => {
      remaining -= 1;
      display.textContent = format(Math.max(0, remaining));
      if (remaining <= 0) {
        clearTimer();
        if (navigator.vibrate) navigator.vibrate([140, 80, 140]);
      }
    }, 1000);
  });

  // Swipe support
  let touchX = null;
  shell.addEventListener('touchstart', (e) => { touchX = e.changedTouches[0].screenX; }, { passive: true });
  shell.addEventListener('touchend', (e) => {
    if (touchX === null) return;
    const dx = e.changedTouches[0].screenX - touchX;
    if (dx < -50) nextBtn.click();
    if (dx > 50) prevBtn.click();
    touchX = null;
  });

  render();
})();
