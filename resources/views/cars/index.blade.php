@extends('layouts.app')
@section('title', 'Xena Automotive — Premium Car Rental')

@section('content')

{{-- ═══════════════════════════ HERO ═══════════════════════════ --}}
<section class="relative bg-[#0f2a5e] text-white overflow-hidden">
    {{-- Subtle grid texture --}}
    <div class="absolute inset-0 opacity-[0.04]"
         style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-28 lg:py-36 grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-blue-300 mb-5">Premium Car Rental</p>
            <h1 class="text-5xl lg:text-6xl font-bold leading-[1.05] tracking-tight mb-6">
                Every Road.<br>
                <span class="text-blue-300">Your Terms.</span>
            </h1>
            <p class="text-slate-300 text-lg leading-relaxed max-w-md mb-10">
                Kendaraan pilihan. Harga transparan. Tanpa biaya tersembunyi.
                Pesan online dalam waktu kurang dari dua menit.
            </p>
            <a href="#fleet"
               class="inline-flex items-center gap-2 bg-white text-[#0f2a5e] font-semibold px-7 py-3.5 rounded hover:bg-blue-50 transition text-sm">
                Telusuri Armada
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Stats strip (Dinamis mengambil total mobil di database) --}}
        @php
            $totalVehicles = \App\Models\Car::count();
        @endphp
        <div class="grid grid-cols-3 gap-4 lg:justify-items-center">
            @foreach([[$totalVehicles . '+', 'Vehicles'], ['50+', 'Cities'], ['98%', 'Satisfaction']] as [$num, $label])
            <div class="border border-blue-700 rounded-lg p-6 text-center w-full max-w-[140px]">
                <div class="text-3xl font-bold text-white">{{ $num }}</div>
                <div class="text-xs text-blue-300 mt-1 tracking-wide">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════ COMPANY PROFILE ═══════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 py-16 border-b border-slate-100">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-blue-500 mb-3">Company Profile</p>
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Redefining Premium Mobility</h2>
            <p class="text-slate-600 leading-relaxed text-sm mb-4">
                Xena Automotive hadir untuk memberikan pengalaman penyewaan mobil yang tak terlupakan. Kami menjembatani kebutuhan mobilitas yang efisien dengan gaya hidup elegan, memastikan setiap perjalanan Anda terasa istimewa.
            </p>
            <p class="text-slate-600 leading-relaxed text-sm">
                Dari city car ekonomis, SUV keluarga, hingga deretan mobil mewah, armada kami dirawat langsung dengan standar dealer resmi. Keamanan, kenyamanan, dan performa tinggi adalah jaminan di setiap kilometer yang Anda tempuh.
            </p>
        </div>
        <div class="rounded-xl overflow-hidden border border-slate-100 bg-slate-50">
            <img src="https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&q=80&w=800" alt="Xena Automotive Showroom" class="w-full h-80 object-cover">
        </div>
    </div>
</section>

{{-- ═══════════════════════════ KEUNGGULAN ═══════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 py-16 border-b border-slate-100">
    <div class="flex items-baseline justify-between mb-10">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-blue-500 mb-2">Our Excellence</p>
            <h2 class="text-2xl font-bold text-slate-900">Kenapa Xena Automotive?</h2>
        </div>
    </div>
    
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Performa Prima', 'desc' => 'Perawatan rutin berkala dengan suku cadang original untuk setiap kendaraan.'],
            ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Harga Transparan', 'desc' => 'Tanpa biaya tersembunyi. Jujur dan sesuai dengan yang ditampilkan di platform.'],
            ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Asuransi Penuh', 'desc' => 'Perjalanan tenang dengan perlindungan asuransi komprehensif (All-Risk).'],
            ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Dukungan 24/7', 'desc' => 'Tim layanan pelanggan dan bantuan darurat siap melayani Anda kapan saja.'],
        ] as $feature)
        <div class="border border-slate-100 bg-slate-50 rounded-xl p-6 hover:shadow-lg transition">
            <div class="text-[#0f2a5e] mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/>
                </svg>
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2">{{ $feature['title'] }}</h3>
            <p class="text-xs text-slate-500 leading-relaxed">{{ $feature['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════ LEADERSHIP ═══════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 py-16 mb-4">
    <div class="flex items-baseline justify-between mb-10">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-blue-500 mb-2">Our Team</p>
            <h2 class="text-2xl font-bold text-slate-900">Meet The Founders</h2>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['name' => 'Irji Sayyid', 'role' => 'Chief Executive Officer', 'img' => asset('images/team/irji.png')],
            ['name' => 'Muhammad Ariq F', 'role' => 'Chief Operating Officer', 'img' => asset('images/team/ariq.png')],
            ['name' => 'Yakaria Yahya', 'role' => 'Chief Technology Officer', 'img' => asset('images/team/yakaria.png')],
            ['name' => 'Dimas Ersyad Hakim', 'role' => 'Chief Marketing Officer', 'img' => asset('images/team/dimas.png')]
        ] as $leader)
        <div class="group border border-slate-100 rounded-xl overflow-hidden hover:shadow-lg transition max-w-[260px] mx-auto w-full">
            <div class="h-48 bg-slate-50">
                <img src="{{ $leader['img'] }}" alt="{{ $leader['name'] }}" class="w-full h-full object-cover">
            </div>
            <div class="p-4 text-center bg-white border-t border-slate-100">
                <h4 class="font-bold text-slate-900 text-sm">{{ $leader['name'] }}</h4>
                <p class="text-[11px] text-slate-400 mt-0.5">{{ $leader['role'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════ FILTER & SEARCH BAR ═══════════════════════════ --}}
<section class="bg-slate-50 border-b border-slate-100 sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-6 py-3 flex flex-wrap gap-4 items-center">
        
        {{-- Kiri: Tombol Filter --}}
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide mr-2">Filter:</span>
            @foreach(['All', 'Sedan', 'SUV', 'Luxury', 'Electric'] as $type)
            <button onclick="filterCars('{{ $type }}')"
                    class="filter-btn px-4 py-1.5 rounded-full text-xs font-medium border border-slate-200 text-slate-600 hover:border-[#0f2a5e] hover:text-[#0f2a5e] transition data-[active=true]:bg-[#0f2a5e] data-[active=true]:text-white data-[active=true]:border-[#0f2a5e]"
                    data-type="{{ $type }}" data-active="{{ $type === 'All' ? 'true' : 'false' }}">
                {{ $type }}
            </button>
            @endforeach
        </div>

        {{-- Kanan: Input Pencarian (Ukuran dikunci pendek & menempel di sebelah filter) --}}
        <div class="relative w-xl shrink-0">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" id="searchInput" placeholder="Cari mobil..." 
                   class="w-full pl-9 pr-4 py-1.5 border border-slate-200 rounded-full text-sm text-slate-700 bg-white focus:outline-none focus:border-[#0f2a5e] focus:ring-1 focus:ring-[#0f2a5e] transition shadow-sm placeholder:text-slate-400">
        </div>

    </div>
</section>

{{-- ═══════════════════════════ FLEET GRID ═══════════════════════════ --}}
<section id="fleet" class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex items-baseline justify-between mb-10">
        <h2 class="text-2xl font-bold text-slate-900">Available Vehicles</h2>
        <span class="text-sm text-slate-400" id="total-cars-count">{{ $cars->total() }} vehicles</span>
    </div>

    @if($cars->isEmpty())
        <div class="text-center py-24 text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13l2-5h14l2 5M5 13v5h14v-5M7 18v1m10-1v1"/>
            </svg>
            <p class="font-medium">No vehicles available right now.</p>
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="car-grid">
           @foreach($cars as $car)
            <article class="car-card group border border-slate-100 rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200"
                     data-type="{{ $car->type }}">

                {{-- Image --}}
                <div class="relative overflow-hidden bg-slate-50 h-48">
                    <img src="{{ $car->image_url ?? 'https://placehold.co/600x300/f1f5f9/94a3b8?text=No+Image' }}"
                         alt="{{ $car->brand }} {{ $car->model }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-[#0f2a5e] text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded">
                        {{ $car->type }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="car-title-wrapper">
                            <h3 class="car-name font-bold text-slate-900 text-base leading-tight">{{ $car->brand }} {{ $car->model }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $car->year }} · {{ $car->type }}</p>
                        </div>
                        <div class="text-right shrink-0 ml-4">
                            <span class="text-xl font-bold text-[#0f2a5e]">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                            <span class="text-xs text-slate-400 block">/hari</span>
                        </div>
                    </div>

                    {{-- Specs Pills --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach([
                            ['icon' => '⚙', 'value' => $car->transmission],
                            ['icon' => '👥', 'value' => $car->seats . ' Kursi'],
                            ['icon' => '⛽', 'value' => $car->fuel_type],
                        ] as $spec)
                        <span class="inline-flex items-center gap-1 bg-slate-50 border border-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded">
                            <span>{{ $spec['icon'] }}</span>{{ $spec['value'] }}
                        </span>
                        @endforeach
                    </div>

                    <a href="{{ route('cars.show', $car->id) }}"
                       class="block w-full text-center bg-[#0f2a5e] hover:bg-[#1a3d82] text-white text-sm font-semibold py-2.5 rounded transition">
                        Lihat & Sewa
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pesan Data Tidak Ditemukan (Disembunyikan secara default) --}}
        <div id="no-results-msg" class="hidden text-center py-20 text-slate-400 border border-dashed border-slate-200 rounded-2xl mt-6">
            <p class="font-medium">Armada tidak ditemukan dengan kata kunci tersebut.</p>
        </div>

        {{-- Pagination --}}
        <div class="mt-12" id="pagination-links">
            {{ $cars->links() }}
        </div>
    @endif
</section>

<script>
    let currentActiveType = 'All';
    const searchInput = document.getElementById('searchInput');

    // Memicu pencarian setiap kali ada ketikan
    if(searchInput) {
        searchInput.addEventListener('keyup', applyFilters);
    }

    // Memicu pemfilteran tipe saat tombol diklik
    function filterCars(type) {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.dataset.active = 'false');
        event.currentTarget.dataset.active = 'true';
        
        currentActiveType = type;
        applyFilters();
    }

    // Logika gabungan untuk mencari dan memfilter sekaligus
    function applyFilters() {
        const query = searchInput.value.toLowerCase();
        const cards = document.querySelectorAll('.car-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const carType = card.dataset.type;
            const carName = card.querySelector('.car-name').textContent.toLowerCase();
            
            // Cek kecocokan Kategori
            const matchType = (currentActiveType === 'All' || carType === currentActiveType);
            
            // Cek kecocokan Search Text
            const matchSearch = carName.includes(query);

            if (matchType && matchSearch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Menampilkan teks jumlah / "Data tidak ditemukan"
        const noResultsMsg = document.getElementById('no-results-msg');
        if (visibleCount === 0) {
            if(noResultsMsg) noResultsMsg.classList.remove('hidden');
        } else {
            if(noResultsMsg) noResultsMsg.classList.add('hidden');
        }
    }
</script>
@endsection