<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'appointment_date' => $this->faker->dateTimeBetween('+1 week', '+3 months'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed']),
            'vehicle_info' => $this->faker->word() . ' ' . $this->faker->year(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
