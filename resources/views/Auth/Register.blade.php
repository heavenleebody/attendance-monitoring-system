<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Campus Room Reservation — Register</title>
<link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/register.js') }}" defer></script>
<script src="{{ asset('js/terms-modal.js') }}" defer></script>
</head>

<body>
<div class="card is-register">
  <!-- LEFT PANEL -->
  <div class="side-panel">
    <div class="side-top">
      <div class="tag">CAMPUS ATTENDANCE MONITOR</div>
      <h1 class="brand-label">ISKEDYUL</h1>
      <div class="divider"></div>
    </div>
    <div class="side-mid">
      Para sa mas maayos na pagsubaybay ng attendance ng bawat Isko at Iska.
    </div>
    <div class="side-bottom">
      <span>EST. 2026 — CAMPUS ACCESS</span>
    </div>
    <div class="watermark">ISKO</div>
    <div class="watermark-top">Iskedyul</div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="form-panel">
    <div class="tabs">
      <button class="tab-btn" type="button" data-auth-go="login" data-url="{{ route('login') }}">LOGIN</button>
      <button class="tab-btn active" type="button">REGISTER</button>
    </div>

    <!-- REGISTER FORM -->
    @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Form posts to the new register.store route (same /register URL) @endphp
    @php // Original: <form id="registerForm" class="active" method="POST" action="{{ route('register') }}"> @endphp
    <form id="registerForm" class="active" method="POST" action="{{ route('register.store') }}">
      @csrf

      <div class="form-heading">
        <h2>Create Your Account</h2>
        <p class="form-sub">Register to start tracking attendance.</p>
      </div>

      @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Split the one Email/Username box into Full Name, Username and Email (the users table needs all three) @endphp
      @php // Original: <div class="field"><label for="email">Email/Username</label><input type="email" id="email" name="email" placeholder="Enter your email or username" required></div> @endphp
      <div class="field">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="name" value="{{ old('name') }}" placeholder="Enter your full name" maxlength="255" required>
      </div>
      @error('name')
        <div class="hint error">{{ $message }}</div>
      @enderror

      <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Choose a username" minlength="3" maxlength="30" pattern="[A-Za-z0-9_\-]+" title="Letters, numbers, dash and underscore only" required>
      </div>
      @error('username')
        <div class="hint error">{{ $message }}</div>
      @enderror

      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
      </div>
      @error('email')
        <div class="hint error">{{ $message }}</div>
      @enderror

      <div class="field password-wrap">
        <label for="regPass">Password</label>
        <input type="password" id="regPass" name="password" placeholder="Create a password" minlength="8" required>
        <button type="button" class="toggle-pass" id="regPassToggle" onclick="togglePassword('regPass', this)">
          <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="icon-eye-off" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a21.6 21.6 0 015.06-6.06M9.9 4.24A10.9 10.9 0 0112 4c7 0 11 7 11 7a21.6 21.6 0 01-3.11 4.26M14.12 14.12a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
        </button>
      </div>

      <!-- PASSWORD STRENGTH (hidden until the user types) -->
      <div class="pw-strength" id="pwStrength" aria-live="polite">
        <div class="pw-meter-head">
          <span class="pw-label">Password strength</span>
          <span class="pw-level" id="pwLevel">Weak</span>
        </div>

        <div class="pw-bar">
          <div class="pw-bar-fill" id="pwBarFill" data-level="0"></div>
        </div>

        <ul class="pw-rules">
          <li data-rule="length">
            <span class="pw-rule-icon"><svg viewBox="0 0 24 24"><polyline points="5 12 10 17 19 7"/></svg></span>
            A minimum of 8 characters
          </li>
          <li data-rule="case">
            <span class="pw-rule-icon"><svg viewBox="0 0 24 24"><polyline points="5 12 10 17 19 7"/></svg></span>
            Lower and uppercase letters
          </li>
          <li data-rule="number">
            <span class="pw-rule-icon"><svg viewBox="0 0 24 24"><polyline points="5 12 10 17 19 7"/></svg></span>
            At least 1 number
          </li>
          <li data-rule="symbol">
            <span class="pw-rule-icon"><svg viewBox="0 0 24 24"><polyline points="5 12 10 17 19 7"/></svg></span>
            At least 1 symbol
          </li>
        </ul>
      </div>

      @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Added the password error message (from the server rules) @endphp
      @error('password')
        <div class="hint error">{{ $message }}</div>
      @enderror

      <div class="field password-wrap">
        <label for="regPassConfirm">Confirm Password</label>
        <input type="password" id="regPassConfirm" name="password_confirmation" placeholder="Re-enter your password" required>
        <button type="button" class="toggle-pass" id="regPassConfirmToggle" onclick="togglePassword('regPassConfirm', this)">
          <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="icon-eye-off" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a21.6 21.6 0 015.06-6.06M9.9 4.24A10.9 10.9 0 0112 4c7 0 11 7 11 7a21.6 21.6 0 01-3.11 4.26M14.12 14.12a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
        </button>
      </div>

      <div class="row-inline">
  <label>
    <input type="checkbox" id="termsCheck" name="terms" required>
    I agree to the
    <a href="#" data-terms-open="terms">Terms of Use</a> &amp;
    <a href="#" data-terms-open="privacy">Privacy Policy</a>
  </label>
</div>

      @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Added the terms error message @endphp
      @error('terms')
        <div class="hint error">{{ $message }}</div>
      @enderror

      <button type="submit" class="submit-btn">CREATE ACCOUNT</button>

      <div class="footnote">
        Already have an account? <a href="{{ route('login') }}" data-auth-go="login">Sign in</a>
      </div>
    </form>
  </div>
</div>
@include('partials.terms-modal')

<script src="{{ asset('js/auth-transition.js') }}"></script>
</body>
</html>