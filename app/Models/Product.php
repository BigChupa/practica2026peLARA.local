<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'sku',
        'category_id',
        'image_path',
        'compatible_make',
        'compatible_model',
        'compatible_year',
        'compatible_vins',
    ];

    protected $casts = [
        'compatible_vins' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')->withPivot('quantity', 'price');
    }
}
