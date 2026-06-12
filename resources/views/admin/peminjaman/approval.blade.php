<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Approval Peminjaman</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 p-8 flex items-center justify-center min-h-screen">
    <div class="max-w-xl w-full bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-[#0f2a5e] mb-6 border-b pb-3">Lembar Approval Peminjaman</h2>
        
        <div class="space-y-4 mb-6 bg-gray-50 p-4 rounded-lg text-sm border">
            <div>
                <span class="text-gray-500 block">Nama Pemohon / Klien:</span>
                <strong class="text-gray-800 text-base">{{ $rental->user->name ?? 'N/A' }}</strong>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-gray-500 block">Mobil Terpilih:</span>
                    <strong class="text-gray-800">{{ $rental->car->brand ?? '' }} {{ $rental->car->model ?? 'N/A' }}</strong>
                </div>
                <div>
                    <span class="text-gray-500 block">Plat Nomor:</span>
                    <strong class="text-gray-800 font-mono">{{ $rental->car->plate_number ?? '-' }}</strong>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-gray-500 block">Tanggal Mulai Pinjam:</span>
                    <strong class="text-gray-800">{{ \Carbon\Carbon::parse($rental->start_date)->format('d F Y') }}</strong>
                </div>
                <div>
                    <span class="text-gray-500 block">Tanggal Batas Kembali:</span>
                    <strong class="text-gray-800">{{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}</strong>
                </div>
            </div>
            <div>
                <span class="text-gray-500 block">Total Nilai Transaksi:</span>
                <strong class="text-gray-900 text-lg">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong>
            </div>
        </div>

        <form action="{{ route('admin.peminjaman.processApprove', $rental->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tentukan Keputusan Status Peminjaman:</label>
                <select name="status" required class="w-full border rounded-lg p-3 bg-white shadow-sm focus:ring-2 focus:ring-[#0f2a5e] text-sm">
                    <option value="pending" {{ $rental->status == 'pending' ? 'selected' : '' }}>Tangguhkan (Pending)</option>
                    <option value="approved" {{ $rental->status == 'approved' ? 'selected' : '' }}>Setujui Pemesanan (Approved)</option>
                    <option value="ongoing" {{ $rental->status == 'ongoing' ? 'selected' : '' }}>Mobil Mulai Dibawa (Ongoing)</option>
                    <option value="completed" {{ $rental->status == 'completed' ? 'selected' : '' }}>Mobil Sudah Kembali (Completed)</option>
                    <option value="cancelled" {{ $rental->status == 'cancelled' ? 'selected' : '' }}>Tolak / Batalkan (Cancelled)</option>
                </select>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('admin.peminjaman.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">Kembali</a>
                <button type="submit" class="px-5 py-2 bg-[#0f2a5e] text-white rounded-lg text-sm font-semibold hover:bg-blue-900 transition-colors shadow-sm">
                    Simpan Keputusan
                </button>
            </div>
        </form>
    </div>
</body>
</html>