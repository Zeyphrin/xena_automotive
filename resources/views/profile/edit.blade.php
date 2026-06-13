@extends('layouts.app')
@section('title', 'Account Settings — DriveElite')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-400 mb-8 flex items-center gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#0f2a5e] transition">Dashboard</a>
        <span>/</span>
        <span class="text-slate-700 font-medium">Edit Profile</span>
    </nav>

    {{-- Form Box --}}
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="bg-[#0f2a5e] px-6 py-5">
            <h2 class="text-white font-bold text-lg">Account Settings</h2>
            <p class="text-blue-300 text-xs mt-1">Perbarui informasi profil dan kata sandi akun Anda</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Section: Informasi Dasar --}}
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 border-b border-slate-100 pb-2">Profile Information</h3>
                
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Alamat Tempat Tinggal</label>
                    <textarea name="address" id="address" rows="3" placeholder="Masukkan alamat lengkap Anda..."
                              class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('address') border-red-400 @enderror">{{ old('address', $user->address) }}</textarea>
                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Section: Ubah Password --}}
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400">Security</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Biarkan kolom di bawah ini kosong jika Anda tidak ingin mengubah password lama.</p>
                </div>
                
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Password Baru</label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('password') border-red-400 @enderror">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition">
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">
                <a href="{{ route('dashboard') }}" 
                   class="bg-white border border-slate-200 text-slate-700 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-slate-50 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-[#0f2a5e] hover:bg-[#1a3d82] text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection