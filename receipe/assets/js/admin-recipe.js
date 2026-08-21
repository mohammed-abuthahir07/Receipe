(function () {
  const form = document.querySelector('[data-admin-recipe]');
  if (!form) return;

  const ingList = form.querySelector('[data-ing-list]');
  const stepList = form.querySelector('[data-step-list]');

  form.querySelector('[data-add-ing]')?.addEventListener('click', () => {
    const row = document.createElement('div');
    row.className = 'repeater-row';
    row.dataset.ingRow = '';
    row.innerHTML = `
      <input name="ing_name[]" placeholder="Ingredient">
      <input name="ing_qty[]" type="number" step="0.01" placeholder="Qty" value="1">
      <input name="ing_unit[]" placeholder="Unit" value="g">
      <button type="button" class="btn btn--ghost" data-remove-row>Remove</button>`;
    ingList.appendChild(row);
  });

  form.querySelector('[data-add-step]')?.addEventListener('click', () => {
    const row = document.createElement('div');
    row.className = 'repeater-row repeater-row--step';
    row.dataset.stepRow = '';
    row.innerHTML = `
      <textarea name="step_text[]" rows="2" placeholder="Step instruction"></textarea>
      <input name="step_timer[]" type="number" min="0" placeholder="Timer sec (optional)">
      <button type="button" class="btn btn--ghost" data-remove-row>Remove</button>`;
    stepList.appendChild(row);
  });

  form.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-remove-row]');
    if (!btn) return;
    const row = btn.closest('.repeater-row');
    const list = row?.parentElement;
    if (!row || !list) return;
    if (list.children.length <= 1) {
      row.querySelectorAll('input, textarea').forEach((el) => { el.value = ''; });
      return;
    }
    row.remove();
  });
})();
