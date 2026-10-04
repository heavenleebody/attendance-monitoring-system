<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //

        // Randell updated this portion | October 4, 2026 | 11:36 AM | A logged-in admin who opens /login or /register goes to the student lookup (default was /)
        $middleware->redirectUsersTo('/student');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
