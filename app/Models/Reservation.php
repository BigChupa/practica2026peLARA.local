<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\Product;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function expireOldReservations()
    {
        $expired = self::where('expires_at', '<', now())->get();

        foreach ($expired as $reservation) {
            $product = $reservation->product;
            if ($product) {
                $product->stock_quantity += $reservation->quantity;
                $product->save();
            }
            $reservation->delete();
        }

        // Якщо залишились замовлення, в яких більше немає резервів, скасовуємо їх.
        Order::where('status', 'pending')
            ->whereDoesntHave('reservations')
            ->each(function (Order $order) {
                $order->update(['status' => 'cancelled']);
            });
    }
}
