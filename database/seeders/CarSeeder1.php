<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CarSeeder1 extends Seeder
{
    public function run(): void
    {
        // 1. Отримуємо дані з файлу
        $path = database_path('database/data/CARS.json');
        
        if (!File::exists($path)) {
            $this->command->error("Файл не знайдено: $path");
            return;
        }

        $json = File::get($path);
        $cars = json_decode($json, true);

        foreach ($cars as $item) {
            // 2. Конвертуємо формат дати з 31/3/2026 у 2026-03-31 для БД
            $createdAt = Carbon::createFromFormat('d/m/Y H:i:s', $item['created_at']);
            $updatedAt = Carbon::createFromFormat('d/m/Y H:i:s', $item['updated_at']);

            // 3. Записуємо в базу
            Car::updateOrCreate(
                ['id' => $item['id']], // Унікальний ідентифікатор
                [
                    'make'       => $item['make'],
                    'model'      => $item['model'],
                    'year'       => $item['year'],
                    'trim'       => $item['trim'],
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]
            );
        }

        $this->command->info('Автомобілі успішно імпортовані!');
    }
}