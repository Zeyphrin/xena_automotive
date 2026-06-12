<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mobil - Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    <div class="flex h-screen overflow-hidden">
        
       @include('admin.components.sidebar')
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Armada Mobil</h2>
                <a href="{{ route('admin.cars.create') }}" class="px-4 py-2 bg-[#0f2a5e] hover:bg-blue-900 text-white font-medium rounded-lg text-sm transition-colors">+ Tambah Mobil</a>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-100">
                                <th class="px-6 py-3 font-medium">Mobil</th>
                                <th class="px-6 py-3 font-medium">Plat Nomor</th>
                                <th class="px-6 py-3 font-medium">Spesifikasi</th>
                                <th class="px-6 py-3 font-medium">Harga / Hari</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach($cars as $car)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 flex items-center">
                                    @if($car->image_url)
                                        <img src="{{ $car->image_url }}" class="w-16 h-10 object-cover rounded mr-3">
                                    @endif
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $car->brand }}</div>
                                        <div class="text-sm text-gray-500">{{ $car->model }} ({{ $car->year }})</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono font-medium text-sm">{{ $car->plate_number }}</td>
                                <td class="px-6 py-4 text-xs space-y-1">
                                    <div>Jenis: {{ $car->type }}</div>
                                    <div>Trans: {{ $car->transmission }}</div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($car->status == 'available')
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Tersedia</span>
                                    @elseif($car->status == 'rented')
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Disewa</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Servis</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-sm space-x-2">
                                    <a href="{{ route('admin.cars.edit', $car->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus mobil ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $cars->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html>