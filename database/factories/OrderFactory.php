<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'total_amount' => $this->faker->numberBetween(1000, 20000),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered']),
            'order_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
