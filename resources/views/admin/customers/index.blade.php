<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kustomer - Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    <div class="flex h-screen overflow-hidden">
        
        @include('admin.components.sidebar')

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Akun Kustomer</h2>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-100">
                                <th class="px-6 py-3 font-medium">Nama Kustomer</th>
                                <th class="px-6 py-3 font-medium">Email</th>
                                <th class="px-6 py-3 font-medium">No. Handphone</th>
                                <th class="px-6 py-3 font-medium">Alamat Lengkap</th>
                                <th class="px-6 py-3 font-medium">Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $customer->name }}</div>
                                    <div class="text-xs text-green-600 font-semibold bg-green-100 inline-block px-2 py-0.5 rounded-full mt-1">Client</div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $customer->email }}</td>
                                <td class="px-6 py-4 text-sm font-mono">{{ $customer->phone ?? 'Belum diisi' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $customer->address }}">
                                    {{ $customer->address ?? 'Belum diisi' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $customer->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data kustomer terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $customers->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html>