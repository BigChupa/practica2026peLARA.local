<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Двигун', 'description' => 'Запчастини для двигуна'],
            ['name' => 'Трансмісія', 'description' => 'Запчастини трансмісії'],
            ['name' => 'Гальма', 'description' => 'Гальмівні системи'],
            ['name' => 'Підвіска', 'description' => 'Деталі підвіски'],
            ['name' => 'Електрика', 'description' => 'Електричні компоненти'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
