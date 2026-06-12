@extends('layouts.app')
@section('title', $car->name . ' — DriveElite')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-400 mb-8 flex items-center gap-2">
        <a href="{{ route('cars.index') }}" class="hover:text-[#0f2a5e] transition">Fleet</a>
        <span>/</span>
        <span class="text-slate-700 font-medium">{{ $car->name }}</span>
    </nav>

    <div class="grid lg:grid-cols-[1fr_420px] gap-12">

        {{-- ════ LEFT COLUMN ════ --}}
        <div>
            {{-- Main Image --}}
            <div class="rounded-2xl overflow-hidden bg-slate-50 mb-6">
                <img src="{{ $car->image_url ?? 'https://placehold.co/900x500/f1f5f9/94a3b8?text=No+Image' }}"
                     alt="{{ $car->name }}"
                     class="w-full object-cover max-h-[420px]">
            </div>

            {{-- Name + Price --}}
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.15em] text-blue-500 mb-1">{{ $car->type }}</p>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $car->name }}</h1>
                    <p class="text-slate-500 text-sm mt-1">{{ $car->year }} · {{ $car->brand }}</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-[#0f2a5e]">${{ number_format($car->price_per_day) }}</p>
                    <p class="text-xs text-slate-400">per day</p>
                </div>
            </div>

            {{-- Description --}}
            @if($car->description)
            <p class="text-slate-600 leading-relaxed mb-8 text-sm border-t border-slate-100 pt-6">
                {{ $car->description }}
            </p>
            @endif

            {{-- Specs Grid --}}
            <div class="border-t border-slate-100 pt-6">
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5">Specifications</h2>
                <dl class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach([
                        ['Engine',       $car->engine      ?? '—'],
                        ['Transmission', $car->transmission ?? '—'],
                        ['Fuel Type',    $car->fuel_type   ?? '—'],
                        ['Seats',        $car->seats       ?? '—'],
                        ['Mileage',      $car->mileage ? $car->mileage . ' mpg' : '—'],
                        ['Color',        $car->color       ?? '—'],
                    ] as [$label, $value])
                    <div class="bg-slate-50 rounded-lg p-4">
                        <dt class="text-[10px] uppercase tracking-widest text-slate-400 mb-1">{{ $label }}</dt>
                        <dd class="font-semibold text-slate-800 text-sm">{{ $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            {{-- Features --}}
            @if($car->features)
            <div class="border-t border-slate-100 pt-6 mt-6">
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-5">Features & Amenities</h2>
                <ul class="grid grid-cols-2 gap-2">
                    @foreach(explode(',', $car->features) as $feature)
                    <li class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-[#0f2a5e] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ trim($feature) }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        {{-- ════ RIGHT COLUMN — BOOKING FORM ════ --}}
        <div class="lg:sticky lg:top-20 self-start">
            <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="bg-[#0f2a5e] px-6 py-5">
                    <h2 class="text-white font-bold text-lg">Reserve This Vehicle</h2>
                    <p class="text-blue-300 text-xs mt-1">Confirm your booking in seconds</p>
                </div>

                <form action="{{ route('cars.book', $car) }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Pick-up Date
                            </label>
                            <input type="date"
                                   name="pickup_date"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('pickup_date') }}"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('pickup_date') border-red-400 @enderror">
                            @error('pickup_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Return Date
                            </label>
                            <input type="date"
                                   name="return_date"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   value="{{ old('return_date') }}"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('return_date') border-red-400 @enderror">
                            @error('return_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-100 pt-2">
                        <p class="text-xs uppercase tracking-widest text-slate-400 mb-3">Driver Details</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Full Name</label>
                        <input type="text"
                               name="full_name"
                               value="{{ old('full_name', auth()->user()?->name) }}"
                               placeholder="John Doe"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('full_name') border-red-400 @enderror">
                        @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Email Address</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', auth()->user()?->email) }}"
                               placeholder="you@example.com"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('email') border-red-400 @enderror">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Phone Number</label>
                        <input type="tel"
                               name="phone"
                               value="{{ old('phone') }}"
                               placeholder="+1 (555) 000-0000"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] focus:border-transparent transition @error('phone') border-red-400 @enderror">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Price Estimate --}}
                    <div class="bg-slate-50 rounded-lg px-4 py-3 flex justify-between items-center" id="price-summary">
                        <span class="text-xs text-slate-500">Estimated Total</span>
                        <span class="text-sm font-bold text-[#0f2a5e]" id="total-price">Select dates</span>
                    </div>

                    @guest
                    <p class="text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded px-3 py-2">
                        <a href="{{ route('login') }}" class="underline font-semibold">Sign in</a> to complete your booking.
                    </p>
                    @endguest

                    <button type="submit"
                            @guest disabled @endguest
                            class="w-full bg-[#0f2a5e] hover:bg-[#1a3d82] disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-lg transition text-sm tracking-wide">
                        Confirm Booking
                    </button>

                    <p class="text-[11px] text-center text-slate-400">Free cancellation up to 24 hours before pick-up.</p>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    const pricePerDay = {{ $car->price_per_day }};
    const pickup = document.querySelector('[name=pickup_date]');
    const ret    = document.querySelector('[name=return_date]');
    const total  = document.getElementById('total-price');

    function calcTotal() {
        if (!pickup.value || !ret.value) { total.textContent = 'Select dates'; return; }
        const diff = Math.ceil((new Date(ret.value) - new Date(pickup.value)) / 86400000);
        total.textContent = diff > 0 ? `$${(diff * pricePerDay).toLocaleString()} (${diff}d)` : 'Invalid range';
    }

    pickup.addEventListener('change', calcTotal);
    ret.addEventListener('change', calcTotal);
</script>
@endsection