<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    
    public function send(Request $request)
{
    $data = $request->validate(['identifier' => ['required', 'string', 'max:255']]);

    return $this->issueCode($request, $data['identifier']);
}

public function resend(Request $request)
{
    $identifier = $request->session()->get('reset_identifier');

    if (! $identifier) {
        return response()->json(['message' => 'Your session expired. Start again.'], 422);
    }

    return $this->issueCode($request, $identifier);
}

private function issueCode(Request $request, string $identifier)
{
    $key = 'otp:' . Str::lower($identifier) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);
        return response()->json(['message' => "Too many requests. Try again in {$seconds} seconds."], 429);
    }
    RateLimiter::hit($key, 600);

    $user = User::where('email', $identifier)->orWhere('username', $identifier)->first();

    if ($user) {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordOtp::updateOrCreate(
            ['email' => $user->email],
            ['code_hash' => Hash::make($code), 'attempts' => 0, 'expires_at' => now()->addMinutes(10)]
        );

        Mail::to($user->email)->send(new OtpMail($code));
    }

    $request->session()->put('reset_identifier', $identifier);
    $request->session()->put('reset_email', $user?->email ?? $identifier);

    return response()->json(['ok' => true]); // same response either way
}

public function verify(Request $request)
{
    $request->validate(['code' => ['required', 'digits:6']]);

    $email = $request->session()->get('reset_email');
    $otp   = $email ? PasswordOtp::where('email', $email)->first() : null;

    if (! $otp || $otp->expires_at->isPast() || $otp->attempts >= 5) {
        return response()->json(['message' => 'That code is invalid or expired. Request a new one.'], 422);
    }

    if (! Hash::check($request->code, $otp->code_hash)) {
        $otp->increment('attempts');
        return response()->json(['message' => 'Incorrect code. Try again.'], 422);
    }

    $otp->delete();
    $request->session()->put('reset_verified', true);

    return response()->json(['ok' => true]);
}

public function update(Request $request)
{
    if (! $request->session()->get('reset_verified')) {
        return response()->json(['message' => 'Verify your code first.'], 403);
    }

    $request->validate([
        'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
    ]);

    $user = User::where('email', $request->session()->get('reset_email'))->first();

    if (! $user) {
        return response()->json(['message' => 'Your session expired. Start again.'], 422);
    }

    $user->forceFill([
        'password'       => Hash::make($request->password),
        'remember_token' => Str::random(60),
    ])->save();

    $request->session()->forget(['reset_identifier', 'reset_email', 'reset_verified']);

    return response()->json(['ok' => true, 'message' => 'Password updated. You can sign in now.']);
}
}