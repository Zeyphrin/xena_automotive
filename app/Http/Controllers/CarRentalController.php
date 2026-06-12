<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon; // Tambahkan ini untuk kalkulasi durasi hari

class CarRentalController extends Controller
{
    public function index()
    {
        // PERBAIKAN 1: Ubah query untuk menggunakan kolom 'status'
        $cars = Car::where('status', 'available')->latest()->paginate(9);
        return view('cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    public function book(Request $request, Car $car)
    {
        // PERBAIKAN 2: Sesuaikan validasi dengan nama kolom di form dan database
        $validated = $request->validate([
            'start_date'  => 'required|date|after_or_equal:today',
            'end_date'    => 'required|date|after:start_date',
        ]);

        // Kalkulasi Total Harga (Harga per hari dikali jumlah hari)
        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $days = $start->diffInDays($end);
        
        // Memastikan minimal sewa adalah 1 hari jika start dan end di hari yang sama
        $rentDays = $days > 0 ? $days : 1; 
        $totalPrice = $rentDays * $car->price_per_day;

        // Simpan ke database sesuai arsitektur yang benar
        Rental::create([
            'car_id'      => $car->id,
            'user_id'     => auth()->id(), // Mengambil ID dari user yang sedang login
            'start_date'  => $validated['start_date'],
            'end_date'    => $validated['end_date'],
            'total_price' => $totalPrice,
            'status'      => 'pending', // Menggunakan enum 'pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function dashboard()
    {
        $rentals = Rental::with('car')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard.index', compact('rentals'));
    }
}   