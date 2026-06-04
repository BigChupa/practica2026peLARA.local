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

    public function index(Request $request)
    {
        $sort = $request->query('sort');

        $makes = Car::select('make')->distinct()->orderBy('make')->pluck('make');
        $models = Car::select('make', 'model')->distinct()->orderBy('model')->get();
        $years = Car::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        $query = Car::withCount('products');

        if ($sort === 'products_desc') {
            $query->orderBy('products_count', 'desc');
        } elseif ($sort === 'products_asc') {
            $query->orderBy('products_count', 'asc');
        } else {
            $query->orderBy('make')->orderBy('model')->orderBy('year');
        }

        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }

        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $cars = $query->paginate(15)->appends($request->query());

        return view('admin.cars.index', compact('cars', 'makes', 'models', 'years', 'sort'));
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
