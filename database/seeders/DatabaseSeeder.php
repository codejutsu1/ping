<?php

namespace Database\Seeders;

use App\Models\Check;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $service = Service::factory()->for($user)->create([
            'name' => 'Daniel API',
            'url' => 'https://codejutsu.xyz',
        ]);

        Check::factory()->for($service)->count(10)->create();
    }
}
