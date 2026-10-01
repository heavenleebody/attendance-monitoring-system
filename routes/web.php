<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('Auth.LogIn');
})->name('login');

Route::get('/register', function () {
    return view('Auth.Register');
})->name('register');

Route::get('/student-registration', function () {
    return view('Auth.StudentRegistration');
})->name('student.registration');

Route::middleware('guest')->group(function () {
    Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])
        ->name('forgot.send');

    Route::post('/verify-code', [ForgotPasswordController::class, 'verify'])
        ->name('otp.verify');

    Route::post('/verify-code/resend', [ForgotPasswordController::class, 'resend'])
        ->name('otp.resend');

    Route::post('/reset-password', [ForgotPasswordController::class, 'update'])
        ->name('reset.update');
});

// TEMPORARY: no 'auth' middleware until the login backend exists.
Route::group([], function () {
    Route::get('/student', [StudentController::class, 'index'])
        ->name('student.lookup');

    Route::get('/student/check', [StudentController::class, 'check'])
        ->name('student.check');

    Route::get('/student/register', [StudentController::class, 'create'])
        ->name('student.register');
});