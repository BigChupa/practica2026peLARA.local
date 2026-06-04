<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart; // Додано для роботи з кошиком авторизованого користувача
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth; // Додано для перевірки авторизації

class ShopController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['category', 'car']);

        $cartQuantity = 0;
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->where('product_id', $product->id)->first();
            if ($item) {
                $cartQuantity = max(1, $item->quantity);
            }
        } else {
            $guestCart = session('guest_cart', []);
            if (isset($guestCart[$product->id]['quantity'])) {
                $cartQuantity = max(1, $guestCart[$product->id]['quantity']);
            }
        }

        return view('shop.product', compact('product', 'cartQuantity'));
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        // Фільтрація за пошуковим запитом (назва або опис)
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($qbuilder) use ($q) {
                $qbuilder->where('name', 'like', "%{$q}%")
                         ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Фільтрація за категорією
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

        // Фільтрація за мінімальною ціною
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }

        // Фільтрація за максимальною ціною
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        // Фільтрація за VIN-кодом автомобіля
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

        // Фільтрація за маркою автомобіля
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

        // Фільтрація за моделлю автомобіля
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

        // Фільтрація за роком випуску автомобіля
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

        // Фільтрація за конкретним ID автомобіля
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

        // Отримання відфільтрованих товарів з пагінацією та збереженням query params
        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        
        // Дані для списків та фільтрів у шаблоні
        $categories = Category::orderBy('name')->get();
        $cars = Car::orderBy('make')->orderBy('model')->orderBy('year')->get();
        $makes = Car::select('make')->distinct()->orderBy('make')->pluck('make')->toArray();

        // --- ЛОГІКА СИНХРОНІЗАЦІЇ КІЛЬКОСТІ З КОШИКА ---
        $cartQuantities = [];

        if (Auth::check()) {
            // Якщо користувач увійшов, беремо кількості товарів з бази даних
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cartQuantities = $cart->items()->pluck('quantity', 'product_id')->toArray();
            }
        } else {
            // Якщо це гість, витягуємо кількості з сесії 'guest_cart'
            $guestCart = session('guest_cart', []);
            foreach ($guestCart as $productId => $data) {
                $cartQuantities[$productId] = $data['quantity'] ?? 1;
            }
        }
        // ----------------------------------------------

        // Повертаємо view разом із масивом кількостей кошика
        return view('shop', compact('products', 'categories', 'cars', 'makes', 'cartQuantities'));
    }

    /**
     * Ajax метод для отримання моделей залежно від обраної марки.
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
     * Ajax метод для отримання років випуску залежно від марки та моделі.
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