<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class CarRentalController extends Controller
{
    public function index()
    {
        $cars = Car::where('available', true)->latest()->paginate(9);
        return view('cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    public function book(Request $request, Car $car)
    {
        $validated = $request->validate([
            'pickup_date'  => 'required|date|after_or_equal:today',
            'return_date'  => 'required|date|after:pickup_date',
            'full_name'    => 'required|string|max:100',
            'email'        => 'required|email',
            'phone'        => 'required|string|max:20',
        ]);

        Rental::create([
            'car_id'      => $car->id,
            'user_id'     => auth()->id(),
            'pickup_date' => $validated['pickup_date'],
            'return_date' => $validated['return_date'],
            'full_name'   => $validated['full_name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'status'      => 'active',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking confirmed.');
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