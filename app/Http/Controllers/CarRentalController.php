<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CarRentalController extends Controller
{
    // ==========================================
    // 1. Menampilkan Halaman Utama (Fleet / Daftar Mobil)
    // ==========================================
    public function index()
    {
        // Hanya tampilkan mobil yang statusnya available
        $cars = Car::where('status', 'available')->latest()->paginate(9);
        
        return view('cars.index', compact('cars'));
    }

    // ==========================================
    // 2. Menampilkan Halaman Detail Mobil
    // ==========================================
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    // ==========================================
    // 3. Memproses Pemesanan (Booking) dari Kustomer
    // ==========================================
    public function book(Request $request, Car $car)
    {
        // Validasi input
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'phone' => 'required|regex:/^[0-9]+$/|min:9|max:15',
            'payment_method' => 'required|string',
        ], [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka saja.',
            'end_date.after_or_equal' => 'Tanggal pengembalian tidak boleh sebelum tanggal penjemputan.'
        ]);

        // Hitung durasi hari
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);
        
        // Jika sewa dan kembali di hari yang sama, hitung 1 hari
        if ($days == 0) { $days = 1; }

        $totalPrice = $days * $car->price_per_day;

        // Simpan transaksi
        Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'fine_amount' => 0,
            'status' => 'pending', 
        ]);

        // Simpan nomor HP terbaru user ke tabel users jika berubah
        $user = Auth::user();
        if (!$user->phone || $user->phone !== $request->phone) {
            $user->update(['phone' => $request->phone]);
        }

        // Kembali ke halaman sebelumnya agar Modal Pop-Up Centang Biru muncul
        return redirect()->back()->with('success', 'Berhasil booking armada dengan metode pembayaran ' . ucwords(str_replace('_', ' ', $request->payment_method)));
    }

    // ==========================================
    // 4. Menampilkan Halaman Dashboard Kustomer (My Rental)
    // ==========================================
    public function dashboard()
    {
        // Menarik data sewa spesifik milik user yang sedang login
        $rentals = Rental::with('car')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard.index', compact('rentals'));
    }
}