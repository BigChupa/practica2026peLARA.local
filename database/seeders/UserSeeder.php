<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Адміністратор
        User::factory()->create([
            'name' => 'Адміністратор',
            'email' => 'admin@autoparts.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Звичайні користувачі
        User::factory(10)->create(['role' => 'user']);
    }
}
