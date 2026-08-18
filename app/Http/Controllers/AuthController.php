<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $loginType = str_contains($request->username, '@') ? 'email' : 'nis';

        $authData = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($authData, $request->boolean('remember-me'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('seller.dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('username');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Ghif: ga pake NIS
            // 'nis' => ['nullable', 'string', 'max:12', 'unique:users,nis'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['nullable', 'in:admin,siswa,pembeli'],
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = $validated['role'] ?? 'pembeli';
        // email_verification tidak ada di schema users; default di DB saja
        $validated['verification_seller'] = false;

        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
