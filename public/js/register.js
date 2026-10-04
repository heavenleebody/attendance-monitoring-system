// Randell updated this portion | October 4, 2026 | 11:36 AM | Removed the first copy of this block, it made the 'Passwords do not match' alert show twice (the second block below does the same)
// Original: document.addEventListener('DOMContentLoaded', function () {
// Original:   const form = document.getElementById('registerForm');
// Original:
// Original:   form.addEventListener('submit', function (e) {
// Original:     const pass = document.getElementById('regPass').value;
// Original:     const confirm = document.getElementById('regPassConfirm').value;
// Original:
// Original:     if (pass !== confirm) {
// Original:       e.preventDefault();
// Original:       alert('Passwords do not match.');
// Original:     }
// Original:   });
// Original:
// Original:   bindPasswordToggleVisibility('regPass', 'regPassToggle');
// Original:   bindPasswordToggleVisibility('regPassConfirm', 'regPassConfirmToggle');
// Original: });

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

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('registerForm');
  const passInput = document.getElementById('regPass');
  const confirmInput = document.getElementById('regPassConfirm');

  const strengthBox = document.getElementById('pwStrength');
  const levelText = document.getElementById('pwLevel');
  const barFill = document.getElementById('pwBarFill');
  const ruleItems = strengthBox.querySelectorAll('[data-rule]');

  const rules = {
    length: (v) => v.length >= 8,
    case:   (v) => /[a-z]/.test(v) && /[A-Z]/.test(v),
    number: (v) => /\d/.test(v),
    symbol: (v) => /[^A-Za-z0-9]/.test(v),
  };

  const levelLabels = { 1: 'Weak', 2: 'Fair', 3: 'Strong', 4: 'Very Strong' };

  function updateStrength() {
    const value = passInput.value;

    // Only show once the user starts typing; hide again if emptied
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

  passInput.addEventListener('input', updateStrength);

  form.addEventListener('submit', function (e) {
    if (!allRulesMet()) {
      e.preventDefault();
      updateStrength();
      strengthBox.classList.add('visible');
      passInput.focus();
      return;
    }

    if (passInput.value !== confirmInput.value) {
      e.preventDefault();
      alert('Passwords do not match.');
    }
  });

  bindPasswordToggleVisibility('regPass', 'regPassToggle');
  bindPasswordToggleVisibility('regPassConfirm', 'regPassConfirmToggle');
});

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