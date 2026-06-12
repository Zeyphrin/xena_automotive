<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil - Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 p-8 flex items-center justify-center min-h-screen">
    <div class="max-w-2xl w-full bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-[#0f2a5e] mb-6 border-b pb-3">Edit Unit Mobil: {{ $car->brand }} {{ $car->model }}</h2>
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT') <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Merek (Brand)</label>
                    <input type="text" name="brand" value="{{ old('brand', $car->brand) }}" required class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#0f2a5e]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Model / Nama Seri</label>
                    <input type="text" name="model" value="{{ old('model', $car->model) }}" required class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#0f2a5e]">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Plat Kendaraan</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', $car->plate_number) }}" required class="w-full border rounded-lg p-2 uppercase focus:ring-2 focus:ring-[#0f2a5e]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Rilis</label>
                    <input type="number" name="year" value="{{ old('year', $car->year) }}" required class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#0f2a5e]">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Bodi</label>
                    <input type="text" name="type" value="{{ old('type', $car->type) }}" placeholder="SUV / MPV / Sedan" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Transmisi</label>
                    <select name="transmission" class="w-full border rounded-lg p-2">
                        <option value="Automatic" {{ old('transmission', $car->transmission) == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option value="Manual" {{ old('transmission', $car->transmission) == 'Manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahan Bakar</label>
                    <input type="text" name="fuel_type" value="{{ old('fuel_type', $car->fuel_type) }}" placeholder="Bensin / Diesel" class="w-full border rounded-lg p-2">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kursi</label>
                    <input type="number" name="seats" value="{{ old('seats', $car->seats) }}" required class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa / Hari (Rp)</label>
                    <input type="number" name="price_per_day" value="{{ old('price_per_day', (int)$car->price_per_day) }}" required class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#0f2a5e]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Mobil</label>
                    <select name="status" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#0f2a5e]">
                        <option value="available" {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                        <option value="rented" {{ old('status', $car->status) == 'rented' ? 'selected' : '' }}>Disewa (Rented)</option>
                        <option value="maintenance" {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>Servis (Maintenance)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL Link Gambar Mobil</label>
                <input type="url" name="image_url" value="{{ old('image_url', $car->image_url) }}" class="w-full border rounded-lg p-2">
                @if($car->image_url)
                    <div class="mt-2">
                        <span class="block text-xs text-gray-500 mb-1">Preview Gambar Saat Ini:</span>
                        <img src="{{ $car->image_url }}" class="h-20 w-auto object-cover rounded border shadow-sm">
                    </div>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Tambahan</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg p-2">{{ old('description', $car->description) }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('admin.cars.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2 bg-[#0f2a5e] text-white rounded-lg text-sm font-medium hover:bg-blue-900 transition-colors">Perbarui Data</button>
            </div>
        </form>
    </div>
</body>
</html>