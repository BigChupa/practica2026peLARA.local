<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder1 extends Seeder
{

public function run(): void
{
    $path = database_path('database/data/RAILWAY.json');
    $json = file_get_contents($path);
    $products = json_decode($json, true);

    foreach ($products as $item) {
        // Используем updateOrCreate, чтобы не было дублей при повторном запуске
        \App\Models\Product::updateOrCreate(
            ['id' => $item['id']], // По какому полю искать
            [
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'stock_quantity' => $item['stock_quantity'],
                'sku' => $item['sku'],
                'category_id' => $item['category_id'],
                'image_path' => $item['image_path'],
                'created_at' => now(), // или преобразуй дату из JSON
                'updated_at' => now(),
            ]
        );
    }
}}