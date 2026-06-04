<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->load('items.product');
            return view('cart', compact('cart'));
        }

        $guest = session('guest_cart', []);
        $items = collect();
        foreach ($guest as $productId => $data) {
            $product = Product::find($productId);
            if (!$product) continue;
            $item = (object)[
                'product' => $product,
                'quantity' => $data['quantity'] ?? 1,
            ];
            $items->push($item);
        }

        $cart = (object)['items' => $items];
        return view('cart', compact('cart'));
    }

    public function syncGuest(Request $request)
    {
        $data = $request->validate([
            'cart' => 'required|array'
        ]);

        $guest = [];
        foreach ($data['cart'] as $productId => $item) {
            $qty = isset($item['quantity']) ? (int)$item['quantity'] : 1;
            if ($qty < 1) $qty = 1;
            $guest[$productId] = ['quantity' => $qty];
        }

        session(['guest_cart' => $guest]);

        return response()->json(['status' => 'ok']);
    }

    public function add(Request $request)
{
    $data = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'nullable|integer|min:0'
    ]);

    $quantity = $data['quantity'] ?? 1;
    $product = Product::find($data['product_id']);

    if (!$product) {
        abort(404);
    }

    if ($quantity > $product->stock_quantity) {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['error' => 'Немає в наявності потрібної кількості товару.'], 422);
        }

        return back()->withErrors(['quantity' => 'Немає в наявності потрібної кількості товару.']);
    }

    if (Auth::check()) {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $item = $cart->items()->where('product_id', $data['product_id'])->first();
        if ($quantity < 1) {
            if ($item) {
                $item->delete();
            }
        } elseif ($item) {
            $item->quantity = $quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $data['product_id'],
                'quantity' => $quantity,
            ]);
        }
    } else {
        $guest = session('guest_cart', []);

        if ($quantity < 1) {
            unset($guest[$data['product_id']]);
        } else {
            $guest[$data['product_id']] = ['quantity' => $quantity];
        }

        session(['guest_cart' => $guest]);
    }

    if ($request->wantsJson() || $request->ajax()) {
        return response()->json(['status' => 'ok']);
    }

    return back()->with('status', 'Товар додано до кошика');
}

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->items()->where('product_id', $data['product_id'])->delete();
        } else {
            $guest = session('guest_cart', []);
            if (isset($guest[$data['product_id']])) {
                unset($guest[$data['product_id']]);
                session(['guest_cart' => $guest]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'ok']);
        }

        return back()->with('status', 'Товар видалено з кошика');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $product = Product::find($data['product_id']);

        if (!$product) {
            abort(404);
        }

        if ($data['quantity'] > $product->stock_quantity) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Немає в наявності потрібної кількості товару.'], 422);
            }

            return back()->withErrors(['quantity' => 'Немає в наявності потрібної кількості товару.']);
        }

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->where('product_id', $data['product_id'])->first();
            if ($item) {
                if ($data['quantity'] < 1) {
                    $item->delete();
                } else {
                    $item->quantity = $data['quantity'];
                    $item->save();
                }
            }
        } else {
            $guest = session('guest_cart', []);
            if (isset($guest[$data['product_id']])) {
                if ($data['quantity'] < 1) {
                    unset($guest[$data['product_id']]);
                } else {
                    $guest[$data['product_id']]['quantity'] = $data['quantity'];
                }
                session(['guest_cart' => $guest]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'ok']);
        }

        return back()->with('status', 'Кількість оновлено');
    }
}
