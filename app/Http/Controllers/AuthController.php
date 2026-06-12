<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Ambil data user yang baru saja login
        $user = Auth::user();

        // KONDISI 1: Jika yang login adalah Admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // KONDISI 2: Jika yang login adalah Client (Tidak memunculkan dasbor admin)
        // Diarahkan langsung ke halaman utama/katalog mobil
        return redirect('/')->with('success', 'Login berhasil! Selamat datang kembali.');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}