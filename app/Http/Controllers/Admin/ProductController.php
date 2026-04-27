<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $cars = Car::orderBy('make')->orderBy('model')->get();
        return view('admin.products.create', compact('categories', 'cars'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'car_id' => 'nullable|exists:cars,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        $data['sku'] = 'AP-' . strtoupper(Str::random(2)) . '-' . rand(10000, 99999);
        $data['stock_quantity'] = $data['stock_quantity'] ?? 0;

        // Если выбран автомобиль, заполнить совместимость
        if (!empty($data['car_id'])) {
            $car = Car::find($data['car_id']);
            if ($car) {
                $data['compatible_make'] = $car->make;
                $data['compatible_model'] = $car->model;
                $data['compatible_year'] = $car->year;
                $data['compatible_vins'] = [$car->vin];
            }
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('products', 'public');
            $data['image_path'] = $path;
        }

        unset($data['image']);
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар успішно створений!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $cars = Car::orderBy('make')->orderBy('model')->get();
        return view('admin.products.edit', compact('product', 'categories', 'cars'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'car_id' => 'nullable|exists:cars,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
                \Storage::disk('public')->delete($product->image_path);
            }
            
            $image = $request->file('image');
            $path = $image->store('products', 'public');
            $data['image_path'] = $path;
        }

        // Если выбран автомобиль, заполнить совместимость
        if (!empty($data['car_id'])) {
            $car = Car::find($data['car_id']);
            if ($car) {
                $data['compatible_make'] = $car->make;
                $data['compatible_model'] = $car->model;
                $data['compatible_year'] = $car->year;
                $data['compatible_vins'] = [$car->vin];
            }
        }

        unset($data['image']);
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар успішно оновлено!');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
            \Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар успішно видалено!');
    }
}

