<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengembalian - Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    <div class="flex h-screen overflow-hidden">
        
        @include('admin.components.sidebar')

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Pengembalian Mobil</h2>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-100">
                                <th class="px-6 py-3 font-medium">Penyewa</th>
                                <th class="px-6 py-3 font-medium">Mobil / Unit</th>
                                <th class="px-6 py-3 font-medium">Jadwal Kembali</th>
                                <th class="px-6 py-3 font-medium">Realisasi Kembali</th>
                                <th class="px-6 py-3 font-medium">Denda (Rp)</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach($rentals as $rental)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $rental->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $rental->user->phone ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $rental->car->brand ?? '' }} {{ $rental->car->model ?? 'Unit Dihapus' }}</div>
                                    <div class="text-xs font-mono text-gray-500">{{ $rental->car->plate_number ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                    {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $rental->actual_return_date ? \Carbon\Carbon::parse($rental->actual_return_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    Rp {{ number_format($rental->fine_amount ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($rental->status == 'ongoing')
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Sedang Dipakai</span>
                                    @elseif($rental->status == 'completed')
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Sudah Kembali</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($rental->status == 'ongoing')
                                        <a href="{{ route('admin.pengembalian.proses', $rental->id) }}" class="inline-flex items-center px-3 py-1.5 bg-[#0f2a5e] hover:bg-blue-900 text-white text-xs font-medium rounded transition-colors shadow-sm">
                                            Proses Masuk
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $rentals->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html> 