<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'password' => ['required', Password::min(6)],
            'role'     => 'required|in:advertiser,webmaster',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        Auth::login($user);

        return $user->role == 'advertiser'
            ? redirect()->route('dashboard')
            : redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
        
            return Auth::user()->role == 'advertiser'
                ? redirect()->route('dashboard')
                : redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Неверные данные для входа.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function me()
    {
        return response()->json(Auth::user());
    }
}
