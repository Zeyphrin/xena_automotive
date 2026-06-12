<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sewa - Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    <div class="flex h-screen overflow-hidden">
        
         @include('admin.components.sidebar')

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Transaksi Penyewaan</h2>
                
                <a href="{{ route('admin.rentals.export') }}" class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export ke Excel
                </a>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-100">
                                <th class="px-6 py-3 font-medium">Klien / Penyewa</th>
                                <th class="px-6 py-3 font-medium">Mobil</th>
                                <th class="px-6 py-3 font-medium">Durasi Sewa</th>
                                <th class="px-6 py-3 font-medium">Total Biaya</th>
                                <th class="px-6 py-3 font-medium">Status Pengajuan</th>
                                <th class="px-6 py-3 font-medium text-center">Ganti Status</th>
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
                                <td class="px-6 py-4 text-sm">
                                    <div>{{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-400">s/d {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($rental->status == 'pending')
                                        <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                    @elseif($rental->status == 'approved')
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Disetujui</span>
                                    @elseif($rental->status == 'ongoing')
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Berjalan</span>
                                    @elseif($rental->status == 'completed')
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Selesai</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Batal</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.rentals.updateStatus', $rental->id) }}" method="POST" class="inline-block">
                                        @csrf 
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="border text-xs rounded p-1 bg-white shadow-sm focus:outline-none focus:ring-1 focus:ring-[#0f2a5e]">
                                            <option value="pending" {{ $rental->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $rental->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                            <option value="ongoing" {{ $rental->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="completed" {{ $rental->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $rental->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                        </select>
                                    </form>
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