<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Randell updated this portion | October 4, 2026 | 11:36 AM | Added imports for the new login and register controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect('/login');
});

// Randell updated this portion | October 4, 2026 | 11:36 AM | Login page is guest only (a logged-in admin gets sent to the student lookup)
// Original: Route::get('/login', function () { return view('Auth.LogIn'); })->name('login');
Route::get('/login', function () {
    return view('Auth.LogIn');
})->middleware('guest')->name('login');

// Randell updated this portion | October 4, 2026 | 11:36 AM | Register page is guest only (a logged-in admin gets sent to the student lookup)
// Original: Route::get('/register', function () { return view('Auth.Register'); })->name('register');
Route::get('/register', function () {
    return view('Auth.Register');
})->middleware('guest')->name('register');

// Randell updated this portion | October 4, 2026 | 11:36 AM | Added: real login (the Log In button used to just redirect)
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

// Randell updated this portion | October 4, 2026 | 11:36 AM | Added: saves the new account (before this POST /register gave a 405 error)
Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');

// Randell updated this portion | October 4, 2026 | 11:36 AM | Added: logout, POST only so a link can't log the admin out
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Randell updated this portion | October 4, 2026 | 11:01 AM | Admin interface: route renamed from student.registration to admin.students.form
// Original: Route::get('/student-registration', function () { return view('Auth.StudentRegistration'); })->name('student.registration');

// Randell updated this portion | October 4, 2026 | 11:36 AM | Added auth middleware so this page can't be opened without logging in
// Original: Route::get('/student-registration', function () { return view('Auth.StudentRegistration'); })->name('admin.students.form');
Route::get('/student-registration', function () {
    return view('Auth.StudentRegistration');
})->middleware('auth')->name('admin.students.form');

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

// Randell updated this portion | October 4, 2026 | 11:36 AM | Login backend now exists, so the student pages are behind auth
// Original: Route::group([], function () {
Route::middleware('auth')->group(function () {
    // Randell updated this portion | October 4, 2026 | 11:01 AM | Admin interface: lookup page renamed (index to showLookup, student.lookup to admin.lookup)
    // Original: Route::get('/student', [StudentController::class, 'index'])->name('student.lookup');
    Route::get('/student', [StudentController::class, 'showLookup'])
        ->name('admin.lookup');

    // Randell updated this portion | October 4, 2026 | 11:01 AM | Admin interface: ID check renamed (check to checkStudent, student.check to admin.lookup.check)
    // Original: Route::get('/student/check', [StudentController::class, 'check'])->name('student.check');
    Route::get('/student/check', [StudentController::class, 'checkStudent'])
        ->name('admin.lookup.check');

    // Randell updated this portion | October 4, 2026 | 11:01 AM | Admin interface: register page renamed (create to showRegisterForm, student.register to admin.students.create)
    // Original: Route::get('/student/register', [StudentController::class, 'create'])->name('student.register');
    Route::get('/student/register', [StudentController::class, 'showRegisterForm'])
        ->name('admin.students.create');

    // Randell updated this portion | October 4, 2026 | 11:01 AM | Added: saves the student from the registration form (before this it only showed the popup)
    Route::post('/student/register', [StudentController::class, 'registerStudent'])
        ->name('admin.students.register');
});