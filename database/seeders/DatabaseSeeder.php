<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Appointment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Запустити окремі seeder-и
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            CarSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);

        // Додатково: Create services (STO services)
        $services = [
            [
                'name' => 'Діагностика двигуна',
                'description' => 'Комп\'ютерна діагностика технічного стану двигуна',
                'price' => 500,
                'duration_minutes' => 30,
            ],
            [
                'name' => 'Заміна олії та фільтрів',
                'description' => 'Профілактична заміна мастила та усіх фільтрів',
                'price' => 1200,
                'duration_minutes' => 45,
            ],
            [
                'name' => 'Заміна гальмівних колодок',
                'description' => 'Заміна передніх/задніх гальмівних колодок',
                'price' => 1500,
                'duration_minutes' => 60,
            ],
            [
                'name' => 'Балансування коліс',
                'description' => 'Балансування та центрування коліс',
                'price' => 600,
                'duration_minutes' => 30,
            ],
            [
                'name' => 'Заміна шин',
                'description' => 'Заміна гумових шин на новий комплект',
                'price' => 2500,
                'duration_minutes' => 90,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create appointments for users
        $users = User::where('role', 'user')->get();
        $services = Service::all();
        foreach ($users as $user) {
            Appointment::factory(2)
                ->for($user)
                ->for($services->random())
                ->create();
        }

        // Create articles
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Article::factory(8)
                ->for($admin)
                ->create([
                    'status' => 'published',
                ]);

            Article::factory(3)
                ->for($admin)
                ->create([
                    'status' => 'draft',
                ]);
        }
    }
}

