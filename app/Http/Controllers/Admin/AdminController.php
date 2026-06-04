<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller{



public function verifyStoAppointment($appointmentId)
{
    $appointment = \App\Models\StoAppointment::findOrFail($appointmentId);
    $appointment->status = 'confirmed';
    $appointment->save();
    return redirect()->route('admin.sto.appointments')->with('success', 'Статус оновлено!');
}

    public function stoAppointments(Request $request)
    {
        $search = trim($request->query('search', ''));
        $searchType = trim($request->query('search_type', ''));

        $baseQuery = \App\Models\StoAppointment::query();

        if ($search !== '') {
            $baseQuery->where(function ($query) use ($search, $searchType) {
                if ($searchType === 'name') {
                    $query->where('name', 'like', "%{$search}%");
                } elseif ($searchType === 'phone') {
                    $query->where('phone', 'like', "%{$search}%");
                } elseif ($searchType === 'service_name') {
                    $query->where('service_name', 'like', "%{$search}%");
                } elseif ($searchType === 'notes') {
                    $query->where('notes', 'like', "%{$search}%");
                } else {
                    $query->where('notes', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('service_name', 'like', "%{$search}%")
                        ->orWhere('appointment_date', 'like', "%{$search}%");
                }
            });
        }

        $toCall = (clone $baseQuery)
            ->where(function ($query) {
                $query->whereNull('status')->orWhere('status', 'pending');
            })
            ->orderByDesc('appointment_date')
            ->get();

        $called = (clone $baseQuery)
            ->where('status', 'confirmed')
            ->orderByDesc('appointment_date')
            ->get();

        return view('admin.sto_appointments', compact('toCall', 'called', 'search', 'searchType'));
    }
    public function index(Request $request)
    {
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $usersCount = User::count();
        $categoriesCount = Category::count();
        $carsCount = Car::count();

        $stoAppointmentsToCall = \App\Models\StoAppointment::whereNull('status')
            ->orWhere('status', 'pending')
            ->get();

        $stoAppointmentsCalled = \App\Models\StoAppointment::where('status', 'confirmed')->get();

        $stoAppointmentsCount = \App\Models\StoAppointment::where('status', 'confirmed')->count();
        $stoAppointmentsPendingCount = \App\Models\StoAppointment::where('status', 'pending')->count();

        $selectedYear = (int) $request->query('year', date('Y'));
        $selectedMonth = (int) $request->query('month', date('m'));

        $completedStatuses = ['confirmed', 'completed'];

        $topProductsOverall = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', $completedStatuses)
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'))
            ->groupBy('order_items.product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $topProductsByMonth = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', $completedStatuses)
            ->whereYear('orders.order_date', $selectedYear)
            ->whereMonth('orders.order_date', $selectedMonth)
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'))
            ->groupBy('order_items.product_id')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        $topOverall = [];
        foreach ($topProductsOverall as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $topOverall[] = [
                    'name' => $product->name,
                    'quantity' => $item->total_quantity,
                    'sales' => round($item->total_sales, 2),
                ];
            }
        }

        $topMonthly = [];
        foreach ($topProductsByMonth as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $topMonthly[] = [
                    'name' => $product->name,
                    'quantity' => $item->total_quantity,
                    'sales' => round($item->total_sales, 2),
                ];
            }
        }

        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', $completedStatuses)
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'))
            ->groupBy('order_items.product_id')
            ->orderByRaw('SUM(order_items.quantity) DESC')
            ->limit(10)
            ->get();

        $productNames = [];
        $productSales = [];
        $productQuantities = [];

        foreach ($topProducts as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $productNames[] = $product->name;
                $productSales[] = round($item->total_sales, 2);
                $productQuantities[] = $item->total_quantity;
            }
        }

        $totalSales = Order::whereIn('status', $completedStatuses)->sum('total_amount') ?? 0;

        $currentMonthSales = Order::whereIn('status', $completedStatuses)
            ->whereYear('order_date', date('Y'))
            ->whereMonth('order_date', date('m'))
            ->sum('total_amount') ?? 0;

        $years = range(date('Y'), date('Y') - 4);
        $months = [
            1 => 'Січень',
            2 => 'Лютий',
            3 => 'Березень',
            4 => 'Квітень',
            5 => 'Травень',
            6 => 'Червень',
            7 => 'Липень',
            8 => 'Серпень',
            9 => 'Вересень',
            10 => 'Жовтень',
            11 => 'Листопад',
            12 => 'Грудень',
        ];

        return view('admin.dashboard', compact(
            'productsCount', 'ordersCount', 'usersCount', 'categoriesCount', 'carsCount',
            'stoAppointmentsToCall', 'stoAppointmentsCalled', 'stoAppointmentsCount', 'stoAppointmentsPendingCount',
            'totalSales', 'currentMonthSales', 'productNames', 'productSales', 'productQuantities',
            'topOverall', 'topMonthly', 'selectedYear', 'selectedMonth', 'years', 'months'
        ));
    }
    
    
}

