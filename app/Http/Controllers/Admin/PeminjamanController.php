<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Mengambil semua data transaksi sewa untuk dipantau status peminjamannya
        $rentals = Rental::with(['user', 'car'])->latest()->paginate(10);
        return view('admin.peminjaman.index', compact('rentals'));
    }

    public function approval(Rental $rental)
    {
        // Membuka halaman detail khusus untuk memproses persetujuan (approval)
        $rental->load(['user', 'car']);
        return view('admin.peminjaman.approval', compact('rental'));
    }

    public function processApprove(Request $request, Rental $rental)
    {
        $request->validate([
            'status' => 'required|in:approved,ongoing,completed,cancelled',
        ]);

        $rental->update(['status' => $request->status]);

        // Sinkronisasi otomatis ke status armada mobil
        if ($request->status === 'approved' || $request->status === 'ongoing') {
            $rental->car->update(['status' => 'rented']);
        } elseif ($request->status === 'completed' || $request->status === 'cancelled') {
            $rental->car->update(['status' => 'available']);
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}