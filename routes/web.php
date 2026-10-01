<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('Auth.LogIn');
})->name('login');

Route::get('/register', function () {
    return view('Auth.Register');
})->name('register');

Route::middleware('guest')->group(function () {
    Route::post('/forgot-password',    [ForgotPasswordController::class, 'send'])->name('forgot.send');
    Route::post('/verify-code',        [ForgotPasswordController::class, 'verify'])->name('otp.verify');
    Route::post('/verify-code/resend', [ForgotPasswordController::class, 'resend'])->name('otp.resend');
    Route::post('/reset-password',     [ForgotPasswordController::class, 'update'])->name('reset.update');
});