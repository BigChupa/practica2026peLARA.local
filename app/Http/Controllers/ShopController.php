<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($qbuilder) use ($q) {
                $qbuilder->where('name', 'like', "%{$q}%")
                         ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category_id')) {
            $catId = $request->input('category_id');
            if (Schema::hasColumn('products', 'category_id')) {
                $query->where('category_id', $catId);
            } else {
                $category = Category::find($catId);
                if ($category) {
                    $query->where('category', $category->name);
                }
            }
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        if ($request->filled('car_vin')) {
            $vin = trim($request->input('car_vin'));
            if (Schema::hasColumn('products', 'compatible_vins')) {
                $query->where(function($q) use ($vin) {
                    $q->where('compatible_vins', 'like', "%{$vin}%")
                      ->orWhere('name', 'like', "%{$vin}%")
                      ->orWhere('description', 'like', "%{$vin}%");
                });
            } else {
                $query->where(function($q) use ($vin) {
                    $q->where('name', 'like', "%{$vin}%")
                      ->orWhere('description', 'like', "%{$vin}%");
                });
            }
        }

        if ($request->filled('car_make')) {
            $value = trim($request->input('car_make'));
            $query->where(function($q) use ($value) {
                if (Schema::hasColumn('products', 'compatible_make')) {
                    $q->where('compatible_make', 'like', "%{$value}%");
                }
                $q->orWhere('name', 'like', "%{$value}%")
                  ->orWhere('description', 'like', "%{$value}%");
            });
        }

        if ($request->filled('car_model')) {
            $value = trim($request->input('car_model'));
            $query->where(function($q) use ($value) {
                if (Schema::hasColumn('products', 'compatible_model')) {
                    $q->where('compatible_model', 'like', "%{$value}%");
                }
                $q->orWhere('name', 'like', "%{$value}%")
                  ->orWhere('description', 'like', "%{$value}%");
            });
        }

        if ($request->filled('car_year')) {
            $value = trim($request->input('car_year'));
            $query->where(function($q) use ($value) {
                if (Schema::hasColumn('products', 'compatible_year')) {
                    $q->where('compatible_year', 'like', "%{$value}%");
                }
                $q->orWhere('name', 'like', "%{$value}%")
                  ->orWhere('description', 'like', "%{$value}%");
            });
        }

        if ($request->filled('car_id')) {
            $car = Car::find($request->input('car_id'));
            if ($car) {
                $query->where(function($q) use ($car) {
                    if (Schema::hasColumn('products', 'car_id')) {
                        $q->orWhere('car_id', $car->id);
                    }
                    if (Schema::hasColumn('products', 'compatible_make')) {
                        $q->orWhere('compatible_make', 'like', "%{$car->make}%")
                          ->orWhere('compatible_model', 'like', "%{$car->model}%")
                          ->orWhere('compatible_year', 'like', "%{$car->year}%");
                    }
                });
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $cars = Car::orderBy('make')->orderBy('model')->orderBy('year')->get();

        // Получить доступные марки для фильтра
        $makes = Car::select('make')->distinct()->orderBy('make')->pluck('make')->toArray();
        
        return view('shop', compact('products', 'categories', 'cars', 'makes'));
    }

    /**
     * API: Получить модели по марке
     */
    public function getModels(Request $request)
    {
        $request->validate(['make' => 'required|string']);
        
        $models = Car::where('make', $request->input('make'))
            ->select('model')
            ->distinct()
            ->orderBy('model')
            ->pluck('model')
            ->toArray();

        return response()->json(['models' => $models]);
    }

    /**
     * API: Получить годы по марке и модели
     */
    public function getYears(Request $request)
    {
        $request->validate([
            'make' => 'required|string',
            'model' => 'required|string'
        ]);
        
        $years = Car::where('make', $request->input('make'))
            ->where('model', $request->input('model'))
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return response()->json(['years' => $years]);
    }
}
