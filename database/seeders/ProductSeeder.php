<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cars = \App\Models\Car::all();

        // Создаем 50 товаров, связанных с случайными автомобилями
        Product::factory(50)->make()->each(function ($product) use ($cars) {
            $car = $cars->random();
            $product->car_id = $car->id;
            $product->compatible_make = $car->make;
            $product->compatible_model = $car->model;
            $product->compatible_year = $car->year;
            $product->compatible_vins = []; // Пусто, так как VIN больше не хранится
            $product->save();
        });
    }
}
