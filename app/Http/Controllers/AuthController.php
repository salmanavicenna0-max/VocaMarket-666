<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Check if username is an email or NIS
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';
        
        $authData = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($authData, $request->boolean('remember-me'))) {
            $request->session()->regenerate();

            // Redirect admin to dashboard, others to home
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('username');
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
