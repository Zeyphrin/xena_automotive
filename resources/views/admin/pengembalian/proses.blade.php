<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pengembalian Unit</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 p-8 flex items-center justify-center min-h-screen">
    <div class="max-w-2xl w-full bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-[#0f2a5e] mb-6 border-b pb-3">Formulir Penerimaan Pengembalian Mobil</h2>
        
        <div class="grid grid-cols-2 gap-6 mb-6 bg-gray-50 p-4 rounded-lg text-sm border">
            <div>
                <span class="text-gray-500 block">Penyewa:</span>
                <strong class="text-gray-800">{{ $rental->user->name ?? 'N/A' }}</strong>
            </div>
            <div>
                <span class="text-gray-500 block">Armada Mobil:</span>
                <strong class="text-gray-800">{{ $rental->car->brand ?? '' }} {{ $rental->car->model ?? 'N/A' }} ({{ $rental->car->plate_number ?? '-' }})</strong>
            </div>
            <div>
                <span class="text-gray-500 block">Tanggal Jatuh Tempo Kembali:</span>
                <strong class="text-red-600" id="end_date">{{ $rental->end_date }}</strong>
            </div>
            <div>
                <span class="text-gray-500 block">Tarif Sewa Pokok / Hari:</span>
                <strong class="text-gray-800">Rp {{ number_format($rental->car->price_per_day, 0, ',', '.') }}</strong>
            </div>
        </div>

        <form action="{{ route('admin.pengembalian.store', $rental->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Realisasi Kembali</label>
                    <input type="date" name="actual_return_date" id="actual_return_date" value="{{ date('Y-m-d') }}" required class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#0f2a5e]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Fisik Mobil</label>
                    <select name="damage_status" id="damage_status" required class="w-full border rounded-lg p-2 bg-white">
                        <option value="normal">Normal / Mulus (Rp 0)</option>
                        <option value="ringan">Rusak Ringan (Rp 250.000)</option>
                        <option value="sedang">Rusak Sedang (Rp 750.000)</option>
                        <option value="berat">Rusak Berat (Rp 2.000.000)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 border-t pt-4 bg-blue-50/50 p-3 rounded-lg">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Denda Keterlambatan (Rp)</label>
                    <input type="number" name="late_fine" id="late_fine" value="0" readonly class="w-full bg-gray-100 border rounded-lg p-2 font-semibold font-mono text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Denda Kerusakan (Rp)</label>
                    <input type="number" name="damage_fine" id="damage_fine" value="0" readonly class="w-full bg-gray-100 border rounded-lg p-2 font-semibold font-mono text-gray-700">
                </div>
            </div>

            <div class="p-4 bg-[#0f2a5e] text-white rounded-lg flex justify-between items-center">
                <span class="font-medium text-sm">Akumulasi Total Denda Pengembalian:</span>
                <span class="text-xl font-bold font-mono" id="total_fine_display">Rp 0</span>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('admin.pengembalian.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium">Batal</a>
                <button type="submit" class="px-5 py-2 bg-[#0f2a5e] text-white rounded-lg text-sm font-semibold hover:bg-blue-900 shadow-sm">
                    Simpan Pengembalian
                </button>
            </div>
        </form>
    </div>

    <script>
        const pricePerDay = {{ $rental->car->price_per_day }};
        const endDateStr = "{{ $rental->end_date }}";

        function hitungDenda() {
            // 1. Hitung Denda Rusak
            const status = document.getElementById('damage_status').value;
            let damageCost = 0;
            if (status === 'ringan') damageCost = 250000;
            else if (status === 'sedang') damageCost = 750000;
            else if (status === 'berat') damageCost = 2000000;
            
            document.getElementById('damage_fine').value = damageCost;

            // 2. Hitung Denda Terlambat Hari
            const actualDate = new Date(document.getElementById('actual_return_date').value);
            const endDate = new Date(endDateStr);
            
            // Set time to midnight to calculate pure days
            actualDate.setHours(0,0,0,0);
            endDate.setHours(0,0,0,0);
            
            let lateCost = 0;
            if (actualDate > endDate) {
                const diffTime = Math.abs(actualDate - endDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                lateCost = diffDays * pricePerDay; // Aturan denda keterlambatan per hari senilai tarif sewa pokok
            }
            
            document.getElementById('late_fine').value = lateCost;

            // 3. Tampilkan Total
            const total = damageCost + lateCost;
            document.getElementById('total_fine_display').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('damage_status').addEventListener('change', hitungDenda);
        document.getElementById('actual_return_date').addEventListener('change', hitungDenda);
        
        // Jalankan kalkulasi pertama kali saat halaman selesai dimuat
        window.onload = hitungDenda;
    </script>
</body>
</html>