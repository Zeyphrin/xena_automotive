<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    // ==========================================
    // FUNGSI UNTUK REGISTRASI KUSTOMER BARU
    // ==========================================
    
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|regex:/^[0-9]+$/|min:9|max:15',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'phone.regex' => 'Nomor telepon wajib berupa angka saja.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Simpan kustomer baru ke tabel users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role diatur sebagai kustomer
        ]);

        // Otomatis buat user langsung login setelah berhasil mendaftar
        Auth::login($user);

        // Alihkan kustomer ke halaman utama armada (Fleet)
        return redirect()->route('cars.index')->with('success', 'Akun Anda berhasil dibuat! Selamat datang di DriveElite.');
    }

    // ==========================================

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}