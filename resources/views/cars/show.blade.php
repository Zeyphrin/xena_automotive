@extends('layouts.app')
@section('title', $car->brand . ' ' . $car->model . ' — DriveElite')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-400 mb-8 flex items-center gap-2">
        <a href="{{ route('cars.index') }}" class="hover:text-[#0f2a5e] transition">Fleet</a>
        <span>/</span>
        <span class="text-slate-700 font-medium">{{ $car->brand }} {{ $car->model }}</span>
    </nav>

    <div class="grid lg:grid-cols-[1fr_420px] gap-12">

        {{-- ════ LEFT COLUMN ════ --}}
        <div>
            {{-- Main Image --}}
            <div class="rounded-2xl overflow-hidden bg-slate-50 mb-6 border border-slate-100">
                <img src="{{ $car->image_url ?? 'https://placehold.co/900x500/f1f5f9/94a3b8?text=No+Image' }}"
                     alt="{{ $car->brand }} {{ $car->model }}"
                     class="w-full object-cover max-h-[420px]">
            </div>

            {{-- Name + Price --}}
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.15em] text-blue-500 mb-1">{{ $car->type }}</p>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $car->brand }} {{ $car->model }}</h1>
                    <p class="text-slate-500 text-sm mt-1">{{ $car->year }} · Plat: <span class="uppercase font-mono">{{ $car->plate_number }}</span></p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-[#0f2a5e]">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-400">per hari</p>
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
                        ['Merek',        $car->brand],
                        ['Model',        $car->model],
                        ['Tipe Bodi',    $car->type],
                        ['Transmisi',    $car->transmission],
                        ['Bahan Bakar',  $car->fuel_type],
                        ['Kapasitas',    $car->seats . ' Kursi'],
                    ] as [$label, $value])
                    <div class="bg-slate-50 rounded-lg p-4 shadow-sm">
                        <dt class="text-[10px] uppercase tracking-widest text-slate-400 mb-1">{{ $label }}</dt>
                        <dd class="font-semibold text-slate-800 text-sm">{{ $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>

        {{-- ════ RIGHT COLUMN — BOOKING FORM ════ --}}
        <div class="lg:sticky lg:top-20 self-start">
            <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm bg-white">
                <div class="bg-[#0f2a5e] px-6 py-5">
                    <h2 class="text-white font-bold text-lg">Reserve This Vehicle</h2>
                    <p class="text-blue-300 text-xs mt-1">Confirm your booking in seconds</p>
                </div>

                <form action="{{ route('cars.book', $car->id) }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Pick-up Date
                            </label>
                            <input type="date" name="start_date" id="start_date" required min="{{ date('Y-m-d') }}"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Return Date
                            </label>
                            <input type="date" name="end_date" id="end_date" required min="{{ date('Y-m-d') }}"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e]">
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-2">
                        <p class="text-xs uppercase tracking-widest text-slate-400 mb-3">Driver Details</p>
                    </div>

                    @auth
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Full Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-500 cursor-not-allowed">
                    </div>
                    @endauth

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Phone Number</label>
                        <input type="text" name="phone" inputmode="numeric" pattern="[0-9]*" required value="{{ auth()->user()?->phone }}" placeholder="081234567890"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] font-mono">
                    </div>

                    {{-- TAMBAHAN: FORM METODE PEMBAYARAN --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Metode Pembayaran</label>
                        <select name="payment_method" required class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f2a5e] bg-white">
                            <option value="" disabled selected>Pilih metode...</option>
                            <option value="bank_transfer">Transfer Bank (BCA / Mandiri / BNI)</option>
                            <option value="ewallet">E-Wallet (GoPay / OVO / Dana)</option>
                            <option value="credit_card">Kartu Kredit / Debit</option>
                            <option value="cash_on_delivery">Bayar Tunai Saat Ambil (Cash)</option>
                        </select>
                    </div>

                    {{-- Price Estimate Kalkulator --}}
                    <div class="bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 flex justify-between items-center mt-4">
                        <span class="text-xs font-semibold text-slate-500">Estimasi Total (<span id="render-days">0</span> hari)</span>
                        <span class="text-lg font-black text-[#0f2a5e]" id="total-price">Pilih Tanggal</span>
                    </div>

                    @guest
                    <p class="text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded px-3 py-2 mt-4">
                        <a href="{{ route('login') }}" class="underline font-semibold">Sign in</a> to complete your booking.
                    </p>
                    @endguest

                    <button type="submit" @guest disabled @endguest
                            class="w-full bg-[#0f2a5e] hover:bg-[#1a3d82] disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-lg transition text-sm tracking-wide mt-4 shadow-md">
                        Confirm Booking
                    </button>
                    
                    <p class="text-[11px] text-center text-slate-400">Pemesanan Anda aman dan dapat dibatalkan 24 jam sebelum Pick-up.</p>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- POP UP SUCCESS (MODAL) BERHASIL BOOKING    --}}
{{-- ========================================== --}}
@if(session('success'))
<div id="success-modal" class="fixed inset-0 z-[100] flex items-center justify-center transition-opacity duration-300" style="background-color: rgba(0, 0, 0, 0.35);">
    
    <div class="bg-white rounded-2xl p-6 w-80 shadow-2xl flex flex-col items-center text-center animate-slide-up">
        
        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-[#0f2a5e]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h3 class="text-xl font-bold text-[#0f2a5e] mb-1">Booking Sukses!</h3>
        <p class="text-slate-500 text-xs mb-6 leading-relaxed">{{ session('success') }}</p>
        
        <button onclick="closeModal()" class="w-full bg-[#0f2a5e] hover:bg-blue-900 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors shadow-md">
            Kembali ke Fleet
        </button>
    </div>
</div>

<style>
    @keyframes slideUpFade {
        0% { 
            opacity: 0; 
            transform: translateY(40px) scale(0.95); 
        }
        100% { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
        }
    }
    .animate-slide-up {
        animation: slideUpFade 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<script>
    function closeModal() {
        const modal = document.getElementById('success-modal');
        modal.style.opacity = '0';
        setTimeout(() => {
            window.location.href = "{{ route('cars.index') }}"; 
        }, 250); 
    }
</script>
@endif

{{-- JAVASCRIPT KALKULATOR HARGA --}}
<script>
    const pricePerDay = {{ $car->price_per_day }};
    const pickup = document.getElementById('start_date');
    const ret    = document.getElementById('end_date');
    const total  = document.getElementById('total-price');
    const daysLabel = document.getElementById('render-days');

    function calcTotal() {
        if (!pickup.value || !ret.value) { 
            total.textContent = 'Pilih Tanggal'; 
            daysLabel.textContent = '0';
            return; 
        }
        
        const startDate = new Date(pickup.value);
        const endDate = new Date(ret.value);
        
        startDate.setHours(0,0,0,0);
        endDate.setHours(0,0,0,0);

        // Jika return date di belakang pickup date
        if (endDate < startDate) { 
            total.textContent = 'Tanggal Tidak Valid'; 
            daysLabel.textContent = '0';
            return; 
        }

        // Hitung selisih hari
        let diffDays = Math.ceil((endDate - startDate) / 86400000);
        
        // Aturan: Jika disewa dan dikembalikan pada hari yang sama = dihitung 1 hari
        if (diffDays === 0) {
            diffDays = 1; 
        }

        const totalPrice = diffDays * pricePerDay;
        
        // Update tampilan HTML
        daysLabel.textContent = diffDays;
        total.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    }

    if (pickup && ret) {
        pickup.addEventListener('change', function() {
            // Mencegah input pengembalian sebelum tanggal pickup
            ret.min = pickup.value;
            // Jika tanggal return kosong, otomatis disamakan dengan pickup
            if(!ret.value) { ret.value = pickup.value; }
            calcTotal();
        });
        ret.addEventListener('change', calcTotal);
    }
</script>
@endsection