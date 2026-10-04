<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Campus Room Reservation — Login</title>
<link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<div class="card">
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
      <button class="tab-btn active" type="button">LOGIN</button>
      <button class="tab-btn" type="button" data-auth-go="register" data-url="{{ route('register') }}">REGISTER</button>
    </div>

    <!-- LOGIN FORM -->
    @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Login form now posts to the server (it had no method, action or csrf token) @endphp
    @php // Original: <form id="loginForm" class="active"> @endphp
    <form id="loginForm" class="active" method="POST" action="{{ route('login.store') }}">
      @csrf
      <div class="form-heading">
        <h2>Welcome Back!</h2>
        <p class="form-sub">Sign in to monitor attendance records.</p>
      </div>

      @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Shows 'Account created' after registering (still hidden otherwise, the reset popup uses it too) @endphp
      @php // Original: <div class="hint success" id="loginStatus" style="display:none;"></div> @endphp
      <div class="hint success" id="loginStatus" style="{{ session('status') ? '' : 'display:none;' }}">{{ session('status') }}</div>

      <div class="field">
        <label>Email / Username</label>
        @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Added name, id and old value, plus the error message under the field @endphp
        @php // Original: <input type="text" placeholder="Enter your email or username" required> @endphp
        <input type="text" id="loginId" name="login" value="{{ old('login') }}" placeholder="Enter your email or username" required>
      </div>
      @error('login')
        <div class="hint error">{{ $message }}</div>
      @enderror

      <div class="field password-wrap">
        <label>Password</label>
        @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Added name and required so the password is sent @endphp
        @php // Original: <input type="password" id="loginPass" placeholder="Enter your password"> @endphp
        <input type="password" id="loginPass" name="password" placeholder="Enter your password" required>
        <button type="button" class="toggle-pass" id="loginPassToggle" onclick="togglePassword('loginPass', this)">
          <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="icon-eye-off" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a21.6 21.6 0 015.06-6.06M9.9 4.24A10.9 10.9 0 0112 4c7 0 11 7 11 7a21.6 21.6 0 01-3.11 4.26M14.12 14.12a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
        </button>
      </div>

      <div class="row-inline">
        @php // Randell updated this portion | October 4, 2026 | 11:36 AM | Added name so Remember me works @endphp
        @php // Original: <label><input type="checkbox"> Remember me</label> @endphp
        <label><input type="checkbox" name="remember" value="1"> Remember me</label>
        <a href="#" id="openReset" style="color:var(--maroon);">Forgot Password?</a>
      </div>

      <button type="submit" class="submit-btn">SIGN IN</button>

      <div class="footnote">
        Don't have an account? <a href="{{ route('register') }}" data-auth-go="register">Create an account</a>
      </div>
    </form>
  </div>
</div>

<div class="terms-modal" id="resetModal" role="dialog" aria-modal="true" aria-labelledby="resetTitle"
     data-send-url="{{ route('forgot.send') }}"
     data-verify-url="{{ route('otp.verify') }}"
     data-resend-url="{{ route('otp.resend') }}"
     data-reset-url="{{ route('reset.update') }}">
  <div class="terms-dialog" style="max-width:440px;">
    <div class="terms-header">
      <div>
        <h3 id="resetTitle" style="font-size:18px; letter-spacing:4px;">Forgot Password</h3>
        <p class="terms-updated" id="resetSub"></p>
      </div>
      <button type="button" class="terms-close" id="resetClose" aria-label="Close">&times;</button>
    </div>

    <div class="terms-body">

      <form id="stepEmail" novalidate>
        <div class="field">
          <label for="resetIdentifier">Email / Username</label>
          <input type="text" id="resetIdentifier" placeholder="Enter your email or username" required>
        </div>
        <div class="hint error" data-err></div>
        <button type="submit" class="submit-btn">SEND CODE</button>
      </form>

      <form id="stepCode" novalidate>
        <div class="field">
  <label for="otp1">Verification code</label>
  <div class="otp-boxes">
    <input type="text" id="otp1" class="otp-box" inputmode="numeric" autocomplete="one-time-code" aria-label="Digit 1">
    <input type="text" class="otp-box" inputmode="numeric" aria-label="Digit 2">
    <input type="text" class="otp-box" inputmode="numeric" aria-label="Digit 3">
    <input type="text" class="otp-box" inputmode="numeric" aria-label="Digit 4">
    <input type="text" class="otp-box" inputmode="numeric" aria-label="Digit 5">
    <input type="text" class="otp-box" inputmode="numeric" aria-label="Digit 6">
  </div>
</div>

        <div class="hint error" data-err></div>
        <button type="submit" class="submit-btn">VERIFY CODE</button>
        <div class="footnote" style="margin-top:0;">
          Didn't get it?
          <button type="button" id="resendBtn" class="link-btn" disabled>Resend code in 60s</button>
        </div>
      </form>

      <form id="stepPass" novalidate>
  <div class="field password-wrap">
    <label for="resetPass">New password</label>
    <input type="password" id="resetPass" placeholder="Enter a new password">
    <button type="button" class="toggle-pass" id="resetPassToggle" onclick="togglePassword('resetPass', this)" aria-label="Show or hide password">
      <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
      <svg class="icon-eye-off" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a21.6 21.6 0 015.06-6.06M9.9 4.24A10.9 10.9 0 0112 4c7 0 11 7 11 7a21.6 21.6 0 01-3.11 4.26M14.12 14.12a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
    </button>
  </div>

  <div class="pw-strength" id="resetStrength" aria-live="polite">
    <div class="pw-meter-head">
      <span class="pw-label">Password strength</span>
      <span class="pw-level" id="resetLevel">Weak</span>
    </div>

    <div class="pw-bar">
      <div class="pw-bar-fill" id="resetBarFill" data-level="0"></div>
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

  <div class="field password-wrap">
    <label for="resetPass2">Confirm new password</label>
    <input type="password" id="resetPass2" placeholder="Re-enter your password">
    <button type="button" class="toggle-pass" id="resetPass2Toggle" onclick="togglePassword('resetPass2', this)" aria-label="Show or hide password">
      <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
      <svg class="icon-eye-off" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a21.6 21.6 0 015.06-6.06M9.9 4.24A10.9 10.9 0 0112 4c7 0 11 7 11 7a21.6 21.6 0 01-3.11 4.26M14.12 14.12a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
    </button>
  </div>

  <div class="hint error" data-err></div>
  <button type="submit" class="submit-btn">RESET PASSWORD</button>
</form>

    </div>
  </div>
</div>

<script src="{{ asset('js/auth-transition.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>