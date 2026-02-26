<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Двигун', 'Гальма', 'Підвіска', 'Електрика', 'Коробка передач'];

        return [
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 5000),
            'stock_quantity' => $this->faker->numberBetween(10, 100),
            'sku' => strtoupper($this->faker->unique()->bothify('AP-####-??')),
            'category' => $this->faker->randomElement($categories),
        ];
    }
}
