<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Sewa Mobil - Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-[#0f2a5e] text-white flex flex-col shadow-lg">
            <div class="h-16 flex items-center justify-center border-b border-blue-800">
                <h1 class="text-2xl font-bold tracking-wider">Xena Auto</h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-blue-200 hover:bg-blue-800 hover:text-white rounded-lg transition-colors">Dashboard</a>
                <a href="{{ route('admin.cars.index') }}" class="flex items-center px-4 py-3 text-blue-200 hover:bg-blue-800 hover:text-white rounded-lg transition-colors">Data Mobil</a>
                <a href="{{ route('admin.rentals.index') }}" class="flex items-center px-4 py-3 bg-blue-800/50 rounded-lg text-white font-medium">Data Sewa</a>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Transaksi Penyewaan</h2>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-100">
                                <th class="px-6 py-3 font-medium">Klien</th>
                                <th class="px-6 py-3 font-medium">Mobil</th>
                                <th class="px-6 py-3 font-medium">Durasi Rentang Tanggal</th>
                                <th class="px-6 py-3 font-medium">Total Biaya</th>
                                <th class="px-6 py-3 font-medium">Status Pengajuan</th>
                                <th class="px-6 py-3 font-medium text-center">Ganti Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach($rentals as $rental)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $rental->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $rental->user->phone }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $rental->car->brand }} {{ $rental->car->model }}</div>
                                    <div class="text-xs text-mono text-gray-500">{{ $rental->car->plate_number }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}
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
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="border text-xs rounded p-1 bg-white shadow-sm focus:outline-none">
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