<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DriveElite — Premium Car Rental')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased font-sans">

    {{-- NAV --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('cars.index') }}" class="text-[#0f2a5e] font-bold text-xl tracking-tight">
                Drive<span class="text-slate-400 font-light">Elite</span>
            </a>
            <div class="flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('cars.index') }}" class="hover:text-[#0f2a5e] transition">Fleet</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-[#0f2a5e] transition">My Rentals</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-[#0f2a5e] text-white px-4 py-1.5 rounded text-xs tracking-wide hover:bg-[#1a3d82] transition">
                            Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-[#0f2a5e] text-white px-4 py-1.5 rounded text-xs tracking-wide hover:bg-[#1a3d82] transition">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-16">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-6 mt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-24 border-t border-slate-100 py-10 text-center text-xs text-slate-400">
        © {{ date('Y') }} DriveElite. All rights reserved.
    </footer>

</body>
</html>