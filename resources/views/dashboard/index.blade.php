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
        <a href="{{ route('cars.index') }}"
           class="inline-flex items-center gap-2 bg-[#0f2a5e] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#1a3d82] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            New Booking
        </a>
    </div>

    {{-- Summary Cards --}}
    @php
        $active    = $rentals->where('status', 'active')->count();
        $completed = $rentals->where('status', 'completed')->count();
        $total     = $rentals->sum(fn($r) => \Carbon\Carbon::parse($r->return_date)->diffInDays($r->pickup_date) * $r->car->price_per_day);
    @endphp

    <div class="grid sm:grid-cols-3 gap-5 mb-12">
        @foreach([
            ['Active Rentals',    $active,    'text-[#0f2a5e]',   'bg-blue-50'],
            ['Completed Trips',   $completed, 'text-emerald-700', 'bg-emerald-50'],
            ['Total Spent',       '$' . number_format($total), 'text-slate-800', 'bg-slate-50'],
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
                            $days = \Carbon\Carbon::parse($rental->return_date)->diffInDays($rental->pickup_date);
                            $cost = $days * $rental->car->price_per_day;
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $rental->car->image_url ?? 'https://placehold.co/80x50/f1f5f9/94a3b8' }}"
                                         alt="{{ $rental->car->name }}"
                                         class="w-14 h-9 object-cover rounded">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $rental->car->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $rental->car->brand }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($rental->pickup_date)->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($rental->return_date)->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-4 text-slate-700">{{ $days }}d</td>
                            <td class="px-5 py-4 font-semibold text-slate-900">${{ number_format($cost) }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $statusMap = [
                                        'active'    => ['bg-blue-50 text-blue-700 border-blue-100',    'Active'],
                                        'completed' => ['bg-emerald-50 text-emerald-700 border-emerald-100', 'Completed'],
                                        'cancelled' => ['bg-red-50 text-red-600 border-red-100',        'Cancelled'],
                                        'pending'   => ['bg-amber-50 text-amber-700 border-amber-100',  'Pending'],
                                    ];
                                    [$cls, $lbl] = $statusMap[$rental->status] ?? ['bg-slate-100 text-slate-600 border-slate-200', ucfirst($rental->status)];
                                @endphp
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
                    $days = \Carbon\Carbon::parse($rental->return_date)->diffInDays($rental->pickup_date);
                    $cost = $days * $rental->car->price_per_day;
                    [$cls, $lbl] = $statusMap[$rental->status] ?? ['bg-slate-100 text-slate-600 border-slate-200', ucfirst($rental->status)];
                @endphp
                <div class="border border-slate-100 rounded-xl p-4 flex gap-4">
                    <img src="{{ $rental->car->image_url ?? 'https://placehold.co/80x50/f1f5f9/94a3b8' }}"
                         alt="{{ $rental->car->name }}"
                         class="w-20 h-14 object-cover rounded-lg shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-bold text-slate-900 truncate">{{ $rental->car->name }}</p>
                                <p class="text-xs text-slate-400">{{ $rental->car->brand }}</p>
                            </div>
                            <span class="inline-flex items-center border {{ $cls }} text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded shrink-0">
                                {{ $lbl }}
                            </span>
                        </div>
                        <div class="mt-2 text-xs text-slate-500 flex gap-4">
                            <span>{{ \Carbon\Carbon::parse($rental->pickup_date)->format('M d') }} → {{ \Carbon\Carbon::parse($rental->return_date)->format('M d, Y') }}</span>
                            <span class="font-semibold text-slate-700">${{ number_format($cost) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection