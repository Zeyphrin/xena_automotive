@extends('layouts.app')
@section('title', 'DriveElite — Fleet')

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
                Handpicked vehicles. Transparent pricing. Zero hidden fees.
                Reserve online in under two minutes.
            </p>
            <a href="#fleet"
               class="inline-flex items-center gap-2 bg-white text-[#0f2a5e] font-semibold px-7 py-3.5 rounded hover:bg-blue-50 transition text-sm">
                Browse Fleet
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Stats strip --}}
        <div class="grid grid-cols-3 gap-4 lg:justify-items-center">
            @foreach([['120+', 'Vehicles'], ['50+', 'Cities'], ['98%', 'Satisfaction']] as [$num, $label])
            <div class="border border-blue-700 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-white">{{ $num }}</div>
                <div class="text-xs text-blue-300 mt-1 tracking-wide">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════ FILTER BAR ═══════════════════════════ --}}
<section class="bg-slate-50 border-b border-slate-100 sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-6 py-3 flex flex-wrap gap-3 items-center">
        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide mr-2">Filter:</span>
        @foreach(['All', 'Sedan', 'SUV', 'Luxury', 'Electric'] as $type)
        <button onclick="filterCars('{{ $type }}')"
                class="filter-btn px-4 py-1.5 rounded-full text-xs font-medium border border-slate-200 text-slate-600 hover:border-[#0f2a5e] hover:text-[#0f2a5e] transition data-[active=true]:bg-[#0f2a5e] data-[active=true]:text-white data-[active=true]:border-[#0f2a5e]"
                data-type="{{ $type }}" data-active="{{ $type === 'All' ? 'true' : 'false' }}">
            {{ $type }}
        </button>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════ FLEET GRID ═══════════════════════════ --}}
<section id="fleet" class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex items-baseline justify-between mb-10">
        <h2 class="text-2xl font-bold text-slate-900">Available Vehicles</h2>
        <span class="text-sm text-slate-400">{{ $cars->total() }} vehicles</span>
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
                         alt="{{ $car->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-[#0f2a5e] text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded">
                        {{ $car->type }}
                    </span>
                    @if($car->featured)
                    <span class="absolute top-3 right-3 bg-[#0f2a5e] text-white text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded">
                        Featured
                    </span>
                    @endif
                </div>

                {{-- Body --}}
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $car->name }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $car->year }} · {{ $car->brand }}</p>
                        </div>
                        <div class="text-right shrink-0 ml-4">
                            <span class="text-xl font-bold text-[#0f2a5e]">${{ number_format($car->price_per_day) }}</span>
                            <span class="text-xs text-slate-400 block">/day</span>
                        </div>
                    </div>

                    {{-- Specs Pills --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach([
                            ['icon' => '⚙', 'value' => $car->transmission],
                            ['icon' => '👥', 'value' => $car->seats . ' Seats'],
                            ['icon' => '⛽', 'value' => $car->fuel_type],
                        ] as $spec)
                        <span class="inline-flex items-center gap-1 bg-slate-50 border border-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded">
                            <span>{{ $spec['icon'] }}</span>{{ $spec['value'] }}
                        </span>
                        @endforeach
                    </div>

                    <a href="{{ route('cars.show', $car) }}"
                       class="block w-full text-center bg-[#0f2a5e] hover:bg-[#1a3d82] text-white text-sm font-semibold py-2.5 rounded transition">
                        View & Book
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $cars->links() }}
        </div>
    @endif
</section>

<script>
function filterCars(type) {
    document.querySelectorAll('.filter-btn').forEach(btn => btn.dataset.active = 'false');
    event.currentTarget.dataset.active = 'true';

    document.querySelectorAll('.car-card').forEach(card => {
        const show = type === 'All' || card.dataset.type === type;
        card.style.display = show ? '' : 'none';
    });
}
</script>
@endsection