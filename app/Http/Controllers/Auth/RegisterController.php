<?php

// Randell added this file | October 4, 2026 | 11:36 AM | Saves a new admin account from the Register page

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            // letters, numbers, dash, underscore only (no @, so it can't look like an email)
            'username' => ['required', 'string', 'min:3', 'max:30', 'alpha_dash:ascii', 'unique:users,username'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            // same rules as the Register page
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'terms'    => ['accepted'],
        ]);

        // the User model hashes the password by itself (casts), no Hash::make needed
        User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'role'     => 'admin',
        ]);

        return redirect()->route('login')->with('status', 'Account created. You can sign in now.');
    }
}
