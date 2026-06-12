<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data ringkasan untuk statistik dasbor
        $stats = [
            'total_cars' => Car::count(),
            'active_rentals' => Rental::whereIn('status', ['approved', 'ongoing'])->count(),
            'pending_rentals' => Rental::where('status', 'pending')->count(),
            'total_clients' => User::where('role', 'client')->count(),
        ];

        // Mengambil 5 transaksi sewa terbaru
        $recent_rentals = Rental::with(['user', 'car'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_rentals'));
    }
}   