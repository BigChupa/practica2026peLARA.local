<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'products')->orderBy('order_date', 'desc');
        $searchType = $request->query('search_type', 'name');

        if ($request->filled('search')) {
            $search = $request->search;

            if ($searchType === 'email') {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('email', 'like', '%' . $search . '%');
                });
            } elseif ($searchType === 'amount') {
                if (is_numeric($search)) {
                    $query->where('total_amount', $search);
                } else {
                    $query->where('total_amount', 'like', '%' . $search . '%');
                }
            } else {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders', 'searchType'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'products');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $status = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update($status);

        if ($oldStatus === 'pending') {
            if ($order->status === 'cancelled') {
                $order->releaseReservations(true);
            } elseif (in_array($order->status, ['processing', 'completed'])) {
                $order->releaseReservations(false);
            }
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Замовлення оновлено');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Замовлення видалено');
    }
}
