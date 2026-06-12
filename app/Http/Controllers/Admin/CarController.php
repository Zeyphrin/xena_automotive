<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|unique:cars,plate_number',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:2000',
            'type' => 'required|string',
            'transmission' => 'required|string',
            'fuel_type' => 'required|string',
            'seats' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        Car::create($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|unique:cars,plate_number,' . $car->id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:2000',
            'type' => 'required|string',
            'transmission' => 'required|string',
            'fuel_type' => 'required|string',
            'seats' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
            'status' => 'required|in:available,rented,maintenance',
        ]);

        $car->update($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus.');
    }
}