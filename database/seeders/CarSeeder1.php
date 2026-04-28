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
        $path = database_path('database/data/CARS.json');
        
        if (!File::exists($path)) {
            $this->command->error("Файл не знайдено: $path");
            return;
        }

        $json = File::get($path);
        $cars = json_decode($json, true);

        foreach ($cars as $item) {
            $createdAt = Carbon::createFromFormat('d/m/Y H:i:s', $item['created_at']);
            $updatedAt = Carbon::createFromFormat('d/m/Y H:i:s', $item['updated_at']);

            Car::updateOrCreate(
                ['id' => $item['id']],
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