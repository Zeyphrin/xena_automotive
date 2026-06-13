@extends('layouts.app')
@section('title', 'My Rentals — DriveElite')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    {{-- Header --}}
    <div class="border-b border-slate-100 pb-8 mb-10 flex items-end justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-blue-500 mb-1">Welcome back</p>
            <h1 class="text-3xl font-bold text-slate-900">{{ auth()->user()->name }}</h1>
        </div>
        
        {{-- Grup Tombol Header (Sejajar di Kanan) --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Edit Profile --}}
            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-slate-50 hover:text-[#0f2a5e] hover:border-[#0f2a5e] transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit Profile
            </a>

            {{-- Tombol New Booking --}}
            <a href="{{ route('cars.index') }}"
               class="inline-flex items-center gap-2 bg-[#0f2a5e] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#1a3d82] transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                New Booking
            </a>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl text-sm font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Summary Cards --}}
    @php
        // Menyesuaikan status dengan enum di database
        $active    = $rentals->whereIn('status', ['pending', 'approved', 'ongoing'])->count();
        $completed = $rentals->where('status', 'completed')->count();
        // Mengambil langsung dari kolom total_price + fine_amount yang sudah dihitung di backend
        $total     = $rentals->sum('total_price') + $rentals->sum('fine_amount');
    @endphp

    <div class="grid sm:grid-cols-3 gap-5 mb-12">
        @foreach([
            ['Active Rentals',    $active,    'text-[#0f2a5e]',   'bg-blue-50'],
            ['Completed Trips',   $completed, 'text-emerald-700', 'bg-emerald-50'],
            ['Total Spent',       'Rp ' . number_format($total, 0, ',', '.'), 'text-slate-800', 'bg-slate-50'],
        ] as [$label, $value, $valueClass, $bg])
        <div class="rounded-xl {{ $bg }} border border-slate-100 px-6 py-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-2">{{ $label }}</p>
            <p class="text-3xl font-bold {{ $valueClass }}">{{ $value }}</p>
        </div>
        @endforeach
    </div>

    {{-- Rentals Table --}}
    <div>
        <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5">Rental History</h2>

        @if($rentals->isEmpty())
            <div class="text-center py-24 border border-dashed border-slate-200 rounded-2xl">
                <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13l2-5h14l2 5M5 13v5h14v-5M7 18v1m10-1v1"/>
                </svg>
                <p class="text-slate-500 font-medium mb-4">You haven't made any bookings yet.</p>
                <a href="{{ route('cars.index') }}"
                class="inline-block bg-[#0f2a5e] text-white text-sm px-5 py-2 rounded-lg hover:bg-[#1a3d82] transition">
                    Browse Fleet
                </a>
            </div>
        @else
            
            @php
                // Mapping status yang sesuai dengan database baru
                $statusMap = [
                    'ongoing'   => ['bg-blue-50 text-blue-700 border-blue-100', 'Ongoing'],
                    'approved'  => ['bg-indigo-50 text-indigo-700 border-indigo-100', 'Approved'],
                    'completed' => ['bg-emerald-50 text-emerald-700 border-emerald-100', 'Completed'],
                    'cancelled' => ['bg-red-50 text-red-600 border-red-100', 'Cancelled'],
                    'pending'   => ['bg-amber-50 text-amber-700 border-amber-100', 'Pending'],
                ];
            @endphp

            {{-- Desktop table --}}
            <div class="hidden md:block rounded-xl border border-slate-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Vehicle</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Pick-up</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Return</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Duration</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Cost</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-5 py-3.5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($rentals as $rental)
                        @php
                            // Menghitung hari menggunakan start_date dan end_date
                            $days = \Carbon\Carbon::parse($rental->start_date)->diffInDays($rental->end_date);
                            if ($days == 0) $days = 1;
                            
                            $cost = $rental->total_price + $rental->fine_amount;
                            [$cls, $lbl] = $statusMap[$rental->status] ?? ['bg-slate-100 text-slate-600 border-slate-200', ucfirst($rental->status)];
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $rental->car->image_url ?? 'https://placehold.co/80x50/f1f5f9/94a3b8' }}"
                                        alt="{{ $rental->car->brand }} {{ $rental->car->model }}"
                                        class="w-14 h-9 object-cover rounded">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $rental->car->brand }} {{ $rental->car->model }}</p>
                                        <p class="text-xs text-slate-400 font-mono">{{ $rental->car->plate_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($rental->start_date)->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($rental->end_date)->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-4 text-slate-700">{{ $days }}d</td>
                            <td class="px-5 py-4 font-semibold text-slate-900">
                                Rp {{ number_format($cost, 0, ',', '.') }}
                                @if($rental->fine_amount > 0)
                                    <span class="block text-[10px] text-red-500 font-normal mt-0.5">+ Denda</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center border {{ $cls }} text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded">
                                    {{ $lbl }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('cars.show', $rental->car) }}"
                                class="text-xs text-[#0f2a5e] font-semibold hover:underline">
                                    View Car →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile cards --}}
            <div class="md:hidden space-y-4">
                @foreach($rentals as $rental)
                @php
                    $days = \Carbon\Carbon::parse($rental->start_date)->diffInDays($rental->end_date);
                    if ($days == 0) $days = 1;
                    
                    $cost = $rental->total_price + $rental->fine_amount;
                    [$cls, $lbl] = $statusMap[$rental->status] ?? ['bg-slate-100 text-slate-600 border-slate-200', ucfirst($rental->status)];
                @endphp
                <div class="border border-slate-100 rounded-xl p-4 flex gap-4">
                    <img src="{{ $rental->car->image_url ?? 'https://placehold.co/80x50/f1f5f9/94a3b8' }}"
                        alt="{{ $rental->car->brand }} {{ $rental->car->model }}"
                        class="w-20 h-14 object-cover rounded-lg shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-bold text-slate-900 truncate">{{ $rental->car->brand }} {{ $rental->car->model }}</p>
                                <p class="text-xs text-slate-400 font-mono">{{ $rental->car->plate_number }}</p>
                            </div>
                            <span class="inline-flex items-center border {{ $cls }} text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded shrink-0">
                                {{ $lbl }}
                            </span>
                        </div>
                        <div class="mt-2 text-xs text-slate-500 flex gap-4">
                            <span>{{ \Carbon\Carbon::parse($rental->start_date)->format('M d') }} → {{ \Carbon\Carbon::parse($rental->end_date)->format('M d, Y') }}</span>
                            <span class="font-semibold text-slate-700">Rp {{ number_format($cost, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection