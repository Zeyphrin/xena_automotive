@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 shadow rounded-lg border border-slate-100">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-[#0f2a5e]">
                Login ke Akun Anda
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Silakan masuk untuk melanjutkan pemesanan
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0f2a5e] focus:border-[#0f2a5e] focus:z-10 sm:text-sm" placeholder="Email address">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0f2a5e] focus:border-[#0f2a5e] focus:z-10 sm:text-sm" placeholder="Password">
                </div>
            </div>

            @error('email')
                <p class="text-red-500 text-sm text-center">{{ $message }}</p>
            @enderror

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#0f2a5e] hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0f2a5e] shadow-sm transition-colors">
                    Sign in
                </button>
            </div>

            {{-- Tambahan Tombol/Link untuk Register --}}
            <div class="text-center mt-4 pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-[#0f2a5e] hover:text-blue-800 transition-colors">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection