<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $cars = Car::orderBy('make')->orderBy('model')->orderBy('year')->paginate(15);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|string|max:4',
            'trim' => 'nullable|string|max:100',
        ]);

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Автомобіль успішно додано');
    }

    public function show(Car $car)
    {
        $car->load('products');
        return view('admin.cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|string|max:4',
            'trim' => 'nullable|string|max:100',
        ]);

        $car->update($data);

        return redirect()->route('admin.cars.show', $car)->with('success', 'Автомобіль оновлено');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Автомобіль видалено');
    }
}
