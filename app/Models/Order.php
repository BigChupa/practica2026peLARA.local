<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'order_date',
        'payment_expires_at',
        'delivery_service',
        'delivery_type',
        'delivery_city',
        'delivery_address',
        'payment_method',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'payment_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')->withPivot('quantity', 'price');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function releaseReservations(bool $restoreStock = false)
    {
        foreach ($this->reservations as $reservation) {
            $product = $reservation->product;
            if ($product && $restoreStock) {
                $product->stock_quantity += $reservation->quantity;
                $product->save();
            }
            $reservation->delete();
        }
    }
}
