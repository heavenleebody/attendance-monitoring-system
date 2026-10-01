// ===== Login form =====

// ----- Precious updated this portion | October 1, 2026 | 8:48 PM -----
document.getElementById('loginForm').addEventListener('submit', function (e) {
  e.preventDefault();

  // Temporary bypass for testing: go directly to Student Lookup
  window.location.href = '/student';
});
// ----- End of Precious' update -----

// ===== Password helpers =====
function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  const eye = btn.querySelector('.icon-eye');
  const eyeOff = btn.querySelector('.icon-eye-off');

  if (input.type === 'password') {
    input.type = 'text';
    eye.style.display = 'none';
    eyeOff.style.display = 'block';
  } else {
    input.type = 'password';
    eye.style.display = 'block';
    eyeOff.style.display = 'none';
  }
}

function bindPasswordToggleVisibility(inputId, toggleId) {
  const input = document.getElementById(inputId);
  const toggle = document.getElementById(toggleId);

  input.addEventListener('input', function () {
    toggle.classList.toggle('visible', input.value.length > 0);
  });
}

bindPasswordToggleVisibility('loginPass', 'loginPassToggle');


// ===== Forgot password popup =====
(function () {
  const token = document.querySelector('meta[name="csrf-token"]').content;
  const modal = document.getElementById('resetModal');
  const sub   = document.getElementById('resetSub');

  const urls = {
    send:   modal.dataset.sendUrl,
    verify: modal.dataset.verifyUrl,
    resend: modal.dataset.resendUrl,
    reset:  modal.dataset.resetUrl,
  };

  const steps = [
    document.getElementById('stepEmail'),
    document.getElementById('stepCode'),
    document.getElementById('stepPass'),
  ];

  const subs = [
    "Enter your email or username and we'll send a 6-digit code.",
    'If an account matches, we sent a code. It expires in 10 minutes.',
    'Create a new password that meets all the rules below.',
  ];

  const focusIds = ['resetIdentifier', 'otp1', 'resetPass'];

  // ----- Password strength (same logic as register) -----
  const passInput    = document.getElementById('resetPass');
  const confirmInput = document.getElementById('resetPass2');
  const strengthBox  = document.getElementById('resetStrength');
  const levelText    = document.getElementById('resetLevel');
  const barFill      = document.getElementById('resetBarFill');
  const ruleItems    = strengthBox.querySelectorAll('[data-rule]');

  const rules = {
    length: (v) => v.length >= 8,
    case:   (v) => /[a-z]/.test(v) && /[A-Z]/.test(v),
    number: (v) => /\d/.test(v),
    symbol: (v) => /[^A-Za-z0-9]/.test(v),
  };

  const levelLabels = {
    1: 'Weak',
    2: 'Fair',
    3: 'Strong',
    4: 'Very Strong'
  };

  function updateStrength() {
    const value = passInput.value;

    // Only show once the user types; hide again if emptied
    strengthBox.classList.toggle('visible', value.length > 0);

    if (value.length === 0) return;

    let score = 0;

    ruleItems.forEach(function (item) {
      const passed = rules[item.dataset.rule](value);

      item.classList.toggle('met', passed);

      if (passed) score++;
    });

    const level = Math.max(score, 1);

    barFill.dataset.level = level;
    levelText.textContent = levelLabels[level];
  }

  function allRulesMet() {
    return Object.values(rules).every((check) => check(passInput.value));
  }

  function resetPasswordUI() {
    [['resetPass', 'resetPassToggle'], ['resetPass2', 'resetPass2Toggle']].forEach(function (pair) {
      const input  = document.getElementById(pair[0]);
      const toggle = document.getElementById(pair[1]);

      input.type = 'password';
      toggle.classList.remove('visible');
      toggle.querySelector('.icon-eye').style.display = 'block';
      toggle.querySelector('.icon-eye-off').style.display = 'none';
    });

    updateStrength();
  }

  passInput.addEventListener('input', updateStrength);

  let lastFocus = null;
  let timer = null;

  function showStep(i) {
    steps.forEach((f, n) => f.classList.toggle('active', n === i));

    sub.textContent = subs[i];

    clearErrors();

    setTimeout(() => {
      document.getElementById(focusIds[i]).focus();
    }, 50);
  }

  function clearErrors() {
    document.querySelectorAll('[data-err]').forEach(e => e.textContent = '');
  }

  function showError(form, msg) {
    form.querySelector('[data-err]').textContent = msg;
  }

  function openReset(e) {
    e.preventDefault();

    lastFocus = document.activeElement;

    modal.classList.add('open');
    document.body.classList.add('modal-open');

    showStep(0);
  }

  function closeReset() {
    modal.classList.remove('open');
    document.body.classList.remove('modal-open');

    steps.forEach(f => f.reset());

    resetPasswordUI();

    clearInterval(timer);

    if (lastFocus) lastFocus.focus();
  }

  async function post(url, body) {
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': token,
      },
      body: JSON.stringify(body),
    });

    const data = await res.json().catch(() => ({}));

    if (!res.ok) {
      const msg = data.errors
        ? Object.values(data.errors)[0][0]
        : (data.message || 'Something went wrong. Try again.');

      throw new Error(msg);
    }

    return data;
  }

  async function submit(form, url, body, onDone) {
    const btn = form.querySelector('.submit-btn');

    btn.disabled = true;
    clearErrors();

    try {
      const data = await post(url, body);
      onDone(data);
    } catch (err) {
      showError(form, err.message);
    } finally {
      btn.disabled = false;
    }
  }

  function startCountdown() {
    const btn = document.getElementById('resendBtn');

    let s = 60;

    btn.disabled = true;
    btn.textContent = 'Resend code in ' + s + 's';

    clearInterval(timer);

    timer = setInterval(() => {
      s--;

      if (s <= 0) {
        clearInterval(timer);

        btn.disabled = false;
        btn.textContent = 'Resend code';
      } else {
        btn.textContent = 'Resend code in ' + s + 's';
      }
    }, 1000);
  }

  steps[0].addEventListener('submit', e => {
    e.preventDefault();

    submit(
      steps[0],
      urls.send,
      {
        identifier: document.getElementById('resetIdentifier').value.trim()
      },
      () => {
        showStep(1);
        startCountdown();
      }
    );
  });

  steps[1].addEventListener('submit', e => {
    e.preventDefault();

    submit(
      steps[1],
      urls.verify,
      {
        code: getCode()
      },
      () => showStep(2)
    );
  });

  steps[2].addEventListener('submit', e => {
    e.preventDefault();

    if (!allRulesMet()) {
      strengthBox.classList.add('visible');
      updateStrength();

      showError(
        steps[2],
        "Your password doesn't meet all the rules yet."
      );

      passInput.focus();

      return;
    }

    if (passInput.value !== confirmInput.value) {
      showError(steps[2], 'Passwords do not match.');
      return;
    }

    submit(
      steps[2],
      urls.reset,
      {
        password: passInput.value,
        password_confirmation: confirmInput.value,
      },
      data => {
        closeReset();

        const status = document.getElementById('loginStatus');

        status.textContent = data.message;
        status.style.display = 'block';
      }
    );
  });

  document.getElementById('resendBtn').addEventListener('click', async () => {
    clearErrors();

    try {
      await post(urls.resend, {});
      startCountdown();
    } catch (err) {
      showError(steps[1], err.message);
    }
  });


  // ----- OTP boxes -----
  const otpBoxes = Array.from(document.querySelectorAll('.otp-box'));

  function getCode() {
    return otpBoxes.map(b => b.value).join('');
  }

  function fillFrom(index, digits) {
    digits
      .split('')
      .slice(0, otpBoxes.length - index)
      .forEach((d, k) => {
        otpBoxes[index + k].value = d;
      });

    otpBoxes[
      Math.min(index + digits.length, otpBoxes.length - 1)
    ].focus();
  }

  otpBoxes.forEach((box, i) => {
    box.addEventListener('focus', () => box.select());

    box.addEventListener('input', () => {
      const digits = box.value.replace(/\D/g, '');

      box.value = '';

      if (digits) {
        fillFrom(i, digits);
      }
    });

    box.addEventListener('keydown', e => {
      if (e.key === 'Backspace' && !box.value && i > 0) {
        e.preventDefault();

        otpBoxes[i - 1].value = '';
        otpBoxes[i - 1].focus();

      } else if (e.key === 'ArrowLeft' && i > 0) {
        otpBoxes[i - 1].focus();

      } else if (e.key === 'ArrowRight' && i < otpBoxes.length - 1) {
        otpBoxes[i + 1].focus();
      }
    });
  });


  bindPasswordToggleVisibility('resetPass', 'resetPassToggle');
  bindPasswordToggleVisibility('resetPass2', 'resetPass2Toggle');

  document.getElementById('openReset').addEventListener('click', openReset);

  document.getElementById('resetClose').addEventListener('click', closeReset);

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && modal.classList.contains('open')) {
      closeReset();
    }
  });

})();