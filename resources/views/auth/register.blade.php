@extends('layouts.app')
@section('title', 'Daftar Akun Baru — DriveElite')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 shadow rounded-lg border border-slate-100">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-[#0f2a5e]">
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Lengkapi formulir di bawah untuk membuat akun kustomer Anda
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                {{-- Input Nama Lengkap --}}
                <div>
                    <label for="name" class="sr-only">Full Name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0f2a5e] focus:border-[#0f2a5e] focus:z-10 sm:text-sm" 
                           placeholder="Nama Lengkap">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Input Alamat Email --}}
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0f2a5e] focus:border-[#0f2a5e] focus:z-10 sm:text-sm" 
                           placeholder="Alamat Email">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Input Nomor Telepon (Hanya Angka) --}}
                <div>
                    <label for="phone" class="sr-only">Phone Number</label>
                    <input id="phone" name="phone" type="text" inputmode="numeric" pattern="[0-9]*" required value="{{ old('phone') }}" 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0f2a5e] focus:border-[#0f2a5e] focus:z-10 sm:text-sm font-mono" 
                           placeholder="Nomor Telepon (Contoh: 081234567890)">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0f2a5e] focus:border-[#0f2a5e] focus:z-10 sm:text-sm" 
                           placeholder="Password">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Input Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="sr-only">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0f2a5e] focus:border-[#0f2a5e] focus:z-10 sm:text-sm" 
                           placeholder="Konfirmasi Password">
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#0f2a5e] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0f2a5e] shadow-sm transition-colors">
                    Daftar Sekarang
                </button>
            </div>

            {{-- Tautan Balik ke Login --}}
            <div class="text-center mt-4 pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-[#0f2a5e] hover:text-blue-800 transition-colors">
                        Login di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection