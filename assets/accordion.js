document.addEventListener('DOMContentLoaded', () => {
  const accordions = document.querySelectorAll('.cuny-wbca-accordion');

  accordions.forEach((accordion, accIndex) => {
    const items = accordion.querySelectorAll('.cuny-wbca-item');

    items.forEach((item, index) => {
      const button = item.querySelector('.cuny-wbca-toggle');
      const panel = item.querySelector('.cuny-wbca-panel');

      if (!button || !panel) return; // Skip if elements not found

      // Assign IDs and ARIA attributes
      const headerId = `accordion-${accIndex}-header-${index}`;
      const panelId = `accordion-${accIndex}-panel-${index}`;

      button.id = headerId;
      button.setAttribute('aria-controls', panelId);
      button.setAttribute('aria-expanded', 'false');
      button.setAttribute('role', 'button');
      button.tabIndex = 0;

      panel.id = panelId;
      panel.setAttribute('role', 'region');
      panel.setAttribute('aria-labelledby', headerId);
      panel.setAttribute('aria-hidden', 'true');
      panel.style.display = 'none';

      // Event listeners
      button.addEventListener('keydown', handleKeyDown);
      button.addEventListener('click', handleClick);

      function handleKeyDown(e) {
        switch (e.key) {
          case 'Enter':
          case ' ':
            e.preventDefault();
            togglePanel();
            break;
          case 'ArrowDown':
            e.preventDefault();
            focusNextItem(1);
            break;
          case 'ArrowUp':
            e.preventDefault();
            focusNextItem(-1);
            break;
          case 'Home':
            e.preventDefault();
            items[0]?.querySelector('.cuny-wbca-toggle')?.focus();
            break;
          case 'End':
            e.preventDefault();
            items[items.length - 1]?.querySelector('.cuny-wbca-toggle')?.focus();
            break;
        }
      }

      function handleClick() {
        togglePanel();
      }

      function focusNextItem(direction) {
        const newIndex = index + direction;
        if (items[newIndex]) {
          items[newIndex].querySelector('.cuny-wbca-toggle')?.focus();
        }
      }

      function togglePanel() {
        const wasExpanded = button.getAttribute('aria-expanded') === 'true';
        
        if (!wasExpanded) {
          // Close all other panels in this accordion
          accordion.querySelectorAll('.cuny-wbca-toggle').forEach(btn => {
            if (btn !== button) {
              btn.setAttribute('aria-expanded', 'false');
              btn.blur();
            }
          });
          
          accordion.querySelectorAll('.cuny-wbca-panel').forEach(pnl => {
            if (pnl !== panel) {
              pnl.setAttribute('aria-hidden', 'true');
              pnl.style.display = 'none';
            }
          });
        }

        // Toggle current panel
        const nowExpanded = !wasExpanded;
        button.setAttribute('aria-expanded', String(nowExpanded));
        panel.setAttribute('aria-hidden', String(!nowExpanded));
        panel.style.display = nowExpanded ? 'block' : 'none';
      }
    });
  });
});
