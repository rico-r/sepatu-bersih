<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function index()
    {
        if (Auth::guard('karyawan')->check()) {
            return redirect(route('karyawan.dashboard'));
        }
        return view('login');
    }

    /**
     * Coba login.
     */
    public function attempt(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('karyawan')->attempt([
            'username' => $validated['username'],
            'password' => $validated['password'],
            'active' => 1,
        ], $request->only('rememberMe'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('karyawan.dashboard'));
        }

        return back()
            ->withInput()
            ->withErrors(['auth' => 'Username atau password tidak benar.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        Auth::guard('karyawan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }
}
