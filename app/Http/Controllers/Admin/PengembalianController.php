<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        // Mengambil data sewa yang berstatus 'ongoing' (sedang berjalan) atau 'completed' (sudah kembali)
        $rentals = Rental::with(['user', 'car'])
            ->whereIn('status', ['ongoing', 'completed'])
            ->latest()
            ->paginate(10);

        return view('admin.pengembalian.index', compact('rentals'));
    }

    public function proses(Rental $rental)
    {
        $rental->load(['user', 'car']);
        return view('admin.pengembalian.proses', compact('rental'));
    }

    public function store(Request $request, Rental $rental)
    {
        $request->validate([
            'actual_return_date' => 'required|date',
            'damage_status' => 'required|in:normal,ringan,sedang,berat',
            'damage_fine' => 'required|numeric|min:0',
            'late_fine' => 'required|numeric|min:0',
        ]);

        // Total denda gabungan dari denda keterlambatan + denda kerusakan fisik
        $totalFine = $request->damage_fine + $request->late_fine;

        // Update data transaksi sewa di database
        $rental->update([
            'actual_return_date' => $request->actual_return_date,
            'fine_amount' => $totalFine,
            'status' => 'completed'
        ]);

        // Kembalikan status ketersediaan unit armada mobil menjadi tersedia (available)
        $rental->car->update(['status' => 'available']);

        return redirect()->route('admin.pengembalian.index')->with('success', 'Mobil sukses dikembalikan. Data denda dan status armada telah diperbarui.');
    }
}