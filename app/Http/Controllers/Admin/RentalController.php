<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        // Mengambil data sewa lengkap dengan relasi user dan car
        $rentals = Rental::with(['user', 'car'])->latest()->paginate(10);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function updateStatus(Request $request, Rental $rental)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,ongoing,completed,cancelled',
        ]);

        $rental->update(['status' => $request->status]);

        // Sinkronisasi otomatis ke status ketersediaan armada mobil
        if ($request->status === 'approved' || $request->status === 'ongoing') {
            $rental->car->update(['status' => 'rented']);
        } elseif ($request->status === 'completed' || $request->status === 'cancelled') {
            $rental->car->update(['status' => 'available']);
        }

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function export()
    {
        $fileName = 'Laporan_Transaksi_Sewa_' . date('Ymd_His') . '.csv';
        $rentals = Rental::with(['user', 'car'])->latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID Transaksi', 
            'Nama Penyewa', 
            'Email', 
            'No HP', 
            'Unit Mobil', 
            'Plat Nomor', 
            'Tanggal Mulai', 
            'Tanggal Selesai', 
            'Total Harga', 
            'Total Denda', 
            'Status Pengajuan'
        ];

        $callback = function() use($rentals, $columns) {
            $file = fopen('php://output', 'w');
            
            // Menyisipkan Byte Order Mark (BOM) agar Excel membaca karakter UTF-8 dengan rapi
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Menggunakan pembatas titik koma (;) agar otomatis terbagi menjadi kolom-kolom di Excel regional Indonesia
            fputcsv($file, $columns, ';');

            foreach ($rentals as $rental) {
                fputcsv($file, [
                    $rental->id,
                    $rental->user->name ?? '-',
                    $rental->user->email ?? '-',
                    $rental->user->phone ?? '-',
                    ($rental->car->brand ?? '') . ' ' . ($rental->car->model ?? ''),
                    $rental->car->plate_number ?? '-',
                    $rental->start_date,
                    $rental->end_date,
                    (int)$rental->total_price,
                    (int)$rental->fine_amount,
                    strtoupper($rental->status),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}