(function () {
  const DURATION = 650;                 // slide time (ms)
  const EASE = 'cubic-bezier(.77, 0, .18, 1)';
  const SLIDE_MIN_WIDTH = 767;          // slide only at this width and up (px)

  const card = document.querySelector('.card');
  if (!card) return;

  const side = card.querySelector('.side-panel');
  const form = card.querySelector('.form-panel');
  const onRegister = card.classList.contains('is-register');

  // Kept as false because the slide wasn't playing with the system check on.
  // Original: window.matchMedia('(prefers-reduced-motion: reduce)').matches
  const reduceMotion = false;

  let leaving = false;

  function setX(el, x, animate) {
    el.style.transition = animate ? 'transform ' + DURATION + 'ms ' + EASE : 'none';
    el.style.transform = x ? 'translateX(' + x + 'px)' : '';
  }

  // Slide only on wide screens where the panels are side by side
  function canSlide() {
    const wideEnough = window.matchMedia('(min-width: ' + SLIDE_MIN_WIDTH + 'px)').matches;
    const sideBySide =
      Math.abs(side.getBoundingClientRect().top - form.getBoundingClientRect().top) <= 5;
    return wideEnough && sideBySide;
  }

  function swapOffsets() {
    const sideW = side.offsetWidth;
    const formW = form.offsetWidth;
    return {
      side: onRegister ? -formW : formW,
      form: onRegister ? sideW : -sideW,
    };
  }

  // ENTER: panels already slid on the previous page, so only fade the form in
  if (sessionStorage.getItem('authSlide')) {
    sessionStorage.removeItem('authSlide');

    if (!reduceMotion && canSlide()) {
      const formEl = form.querySelector('form');
      formEl.style.transition = 'none';
      formEl.style.opacity = 0;
      void card.offsetWidth;
      formEl.style.transition = 'opacity 350ms ease';
      formEl.style.opacity = 1;
    }
  }

  // LEAVE
  document.querySelectorAll('[data-auth-go]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      const url = el.dataset.url || el.href;
      if (!url) return;

      e.preventDefault();
      if (leaving) return;

      // Phones (or reduced motion): no animation, just go
      if (reduceMotion || !canSlide()) {
        window.location.href = url;
        return;
      }

      leaving = true;
      const o = swapOffsets();
      setX(side, o.side, true);
      setX(form, o.form, true);

      sessionStorage.setItem('authSlide', el.dataset.authGo);
      setTimeout(function () { window.location.href = url; }, DURATION);
    });
  });

  // Reset if restored from the back/forward cache
  window.addEventListener('pageshow', function (e) {
    if (e.persisted) {
      leaving = false;
      setX(side, 0, false);
      setX(form, 0, false);
    }
  });
})();