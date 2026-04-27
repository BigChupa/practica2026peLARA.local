<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Двигун', 'Гальма', 'Підвіска', 'Електрика', 'Коробка передач'];

        $compatibilities = [
            ['make' => 'Toyota', 'model' => 'Camry', 'year' => '2018', 'vins' => ['JT2BG12K3J0123456', '4T1BF1FK8HU123456']],
            ['make' => 'BMW',    'model' => 'X5',   'year' => '2020', 'vins' => ['5UXCR6C59L9K12345', '5UXCR6C56L9K23456']],
            ['make' => 'Kia',    'model' => 'Sportage', 'year' => '2019', 'vins' => ['KNDPB3AC8J7L12345', 'KNDPNCAC7J7L23456']],
        ];
        $match = $this->faker->randomElement($compatibilities);

        return [
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 5000),
            'stock_quantity' => $this->faker->numberBetween(10, 100),
            'sku' => strtoupper($this->faker->unique()->bothify('AP-####-??')),
            'category_id' => null,
            'compatible_make' => $match['make'],
            'compatible_model' => $match['model'],
            'compatible_year' => $match['year'],
            'compatible_vins' => $match['vins'],
        ];
    }
}
