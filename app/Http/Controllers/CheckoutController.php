<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DeliveryOffice;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->load('items.product');
            $items = $cart->items;
        } else {
            $guest = session('guest_cart', []);
            $items = collect();
            foreach ($guest as $productId => $data) {
                $product = Product::find($productId);
                if (!$product) continue;
                $items->push((object)[
                    'product' => $product,
                    'quantity' => $data['quantity'] ?? 1,
                ]);
            }
        }

        return view('checkout', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'delivery_service' => 'required|in:nova_poshta,ukrposhta',
            'delivery_type' => 'required|in:post_office,postomat,home_delivery',
            'delivery_city' => 'required|string|max:255',
            'delivery_address' => 'required|string',
        ]);

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->load('items.product');
            $items = $cart->items;
        } else {
            $guest = session('guest_cart', []);
            $items = collect();
            foreach ($guest as $productId => $d) {
                $product = Product::find($productId);
                if (!$product) continue;
                $items->push((object)['product' => $product, 'quantity' => $d['quantity']]);
            }
        }

        if ($items->isEmpty()) {
            return back()->withErrors(['cart' => 'Кошик порожній']);
        }

        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Str::random(16),
                    'role' => 'user',
                ]);
            }
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // Prepare delivery information
        $deliveryCity = $data['delivery_city'];
        $deliveryAddress = $data['delivery_address'];

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
            'status' => 'pending',
            'delivery_service' => $data['delivery_service'],
            'delivery_type' => $data['delivery_type'],
            'delivery_city' => $deliveryCity,
            'delivery_address' => $deliveryAddress,
            'payment_method' => 'bank_transfer',
        ]);

        foreach ($items as $item) {
            $order->products()->attach($item->product->id, ['quantity' => $item->quantity, 'price' => $item->product->price]);
        }

        session(['last_order_id' => $order->id, 'last_order_contact' => $data]);

        if (Auth::check()) {
            $cart->items()->delete();
        } else {
            session()->forget('guest_cart');
        }

        return redirect()->route('checkout.confirmation');
    }

    public function confirmation(Request $request)
    {
        $orderId = session('last_order_id');
        if (!$orderId) {
            return redirect()->route('shop');
        }
        $order = Order::with('products')->find($orderId);
        $contact = session('last_order_contact', []);

        $bank = [
            'recipient' => 'ТОВ «Моторист»',
            'iban' => 'UA12 3456 7890 1234 5678 9012 345',
            'bank' => 'ПриватБанк',
            'mfo' => '300001',
            'note' => 'Платіж за замовлення #' . $order->id,
        ];

        return view('checkout.confirmation', compact('order', 'contact', 'bank'));
    }
}
