document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('termsModal');
  if (!modal) return;

  const checkbox = document.getElementById('termsCheck');
  const tabs = modal.querySelectorAll('[data-terms-tab]');
  const panes = modal.querySelectorAll('[data-terms-pane]');
  const body = modal.querySelector('.terms-body');
  let lastFocused = null;

  function showTab(name) {
    tabs.forEach(function (t) {
      t.classList.toggle('active', t.dataset.termsTab === name);
    });
    panes.forEach(function (p) {
      p.classList.toggle('active', p.dataset.termsPane === name);
    });
    body.scrollTop = 0;
  }

  function openModal(tab) {
    lastFocused = document.activeElement;
    showTab(tab || 'terms');
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
    modal.querySelector('.terms-close').focus();
  }

  function closeModal() {
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
    if (lastFocused) lastFocused.focus();
  }

  // Open from the links in the checkbox label
  document.querySelectorAll('[data-terms-open]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      openModal(el.dataset.termsOpen);
    });
  });

  // Tabs
  tabs.forEach(function (t) {
    t.addEventListener('click', function () { showTab(t.dataset.termsTab); });
  });

  // Close: X button, Close button, backdrop click
  modal.querySelector('.terms-close').addEventListener('click', closeModal);
  modal.querySelector('[data-terms-close]').addEventListener('click', closeModal);
  modal.addEventListener('click', function (e) {
    if (e.target === modal) closeModal();
  });

  // I Agree: tick the checkbox and close
  document.getElementById('termsAccept').addEventListener('click', function () {
    if (checkbox) {
      checkbox.checked = true;
      checkbox.dispatchEvent(new Event('change', { bubbles: true }));
    }
    closeModal();
  });

  // Esc to close, and keep Tab focus inside the popup
  document.addEventListener('keydown', function (e) {
    if (!modal.classList.contains('open')) return;

    if (e.key === 'Escape') {
      closeModal();
      return;
    }

    if (e.key === 'Tab') {
      const focusable = modal.querySelectorAll('button, [href], input, [tabindex]:not([tabindex="-1"])');
      const first = focusable[0];
      const last = focusable[focusable.length - 1];

      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    }
  });
});