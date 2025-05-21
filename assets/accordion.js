document.addEventListener('DOMContentLoaded', () => {
  const accordions = document.querySelectorAll('.cuny-wbca-accordion');

  accordions.forEach((accordion, accIndex) => {
    const items = accordion.querySelectorAll('.cuny-wbca-item');

    items.forEach((item, index) => {
      const headerWrapper = item.querySelector('.cuny-wbca-header');
      const button = item.querySelector('.cuny-wbca-toggle');
      const panel = item.querySelector('.cuny-wbca-panel');

      // Assign IDs and ARIA
      const headerId = `accordion-${accIndex}-header-${index}`;
      const panelId = `accordion-${accIndex}-panel-${index}`;

      button.setAttribute('id', headerId);
      button.setAttribute('aria-controls', panelId);
      button.setAttribute('aria-expanded', 'false');
      button.setAttribute('role', 'button');
      button.setAttribute('tabindex', '0');

      panel.setAttribute('id', panelId);
      panel.setAttribute('role', 'region');
      panel.setAttribute('aria-labelledby', headerId);
      panel.setAttribute('aria-hidden', 'true');
      panel.style.display = 'none';

      // Keyboard controls
      button.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          togglePanel(button, panel);
        } else if (e.key === 'ArrowDown') {
          e.preventDefault();
          const next = items[index + 1]?.querySelector('.cuny-wbca-toggle');
          if (next) next.focus();
        } else if (e.key === 'ArrowUp') {
          e.preventDefault();
          const prev = items[index - 1]?.querySelector('.cuny-wbca-toggle');
          if (prev) prev.focus();
        }
      });

      // Click toggle
      button.addEventListener('click', () => togglePanel(button, panel));
    });
  });

  function togglePanel(button, panel) {
    const expanded = button.getAttribute('aria-expanded') === 'true';
    button.setAttribute('aria-expanded', String(!expanded));
    panel.setAttribute('aria-hidden', String(expanded));
    panel.style.display = expanded ? 'none' : 'block';
  }
});
