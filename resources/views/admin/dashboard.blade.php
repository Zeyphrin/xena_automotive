<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sewa Mobil</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        @include('admin.components.sidebar')

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-gray-800">Overview</h2>
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-600 mr-2">Halo, {{ auth()->user()->name }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#0f2a5e] text-white flex items-center justify-center font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                        <div class="p-3 rounded-lg bg-blue-50 text-[#0f2a5e]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Armada</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_cars'] }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                        <div class="p-3 rounded-lg bg-green-50 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Sewa Berjalan</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_rentals'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                        <div class="p-3 rounded-lg bg-yellow-50 text-yellow-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Menunggu Approval</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_rentals'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                        <div class="p-3 rounded-lg bg-purple-50 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Klien</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_clients'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h2>
                        <a href="#" class="text-sm text-[#0f2a5e] hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                                    <th class="px-6 py-3 font-medium">Klien</th>
                                    <th class="px-6 py-3 font-medium">Mobil</th>
                                    <th class="px-6 py-3 font-medium">Tanggal Sewa</th>
                                    <th class="px-6 py-3 font-medium">Total Harga</th>
                                    <th class="px-6 py-3 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-700">
                                @forelse($recent_rentals as $rental)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">{{ $rental->user?->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $rental->user?->phone ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium">{{ $rental->car?->brand }} {{ $rental->car?->model }}</div>
                                            <div class="text-xs text-gray-500">{{ $rental->car?->plate_number ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }} - 
                                            {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($rental->status == 'pending')
                                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                            @elseif($rental->status == 'ongoing' || $rental->status == 'approved')
                                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Active</span>
                                            @elseif($rental->status == 'completed')
                                                <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Selesai</span>
                                            @else
                                                <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi penyewaan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>