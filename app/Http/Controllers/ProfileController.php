<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir edit profil kustomer.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan profil kustomer ke database.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input form sesuai data kolom database
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'address' => ['nullable', 'string', 'max:500'], 
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'Alamat email ini sudah digunakan oleh pengguna lain.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ]);

        // Perbarui data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Sesuaikan nama kolom database Anda (misal: 'address' atau 'alamat')
        $user->address = $request->address;

        // Perbarui password hanya jika kolom diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Alihkan kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}