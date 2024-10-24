<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'user@email.com',
            'password' => '$2y$12$1cYRc1/zANktbhBoQPZcnOS615JBWZfZdo0ZNml6ghittrozC/oju',
            'role_id' => 2,
        ]);
        $this->call([
            RolesTableSeeder::class,
            JobsTableSeeder::class,
            ProvincesTableSeeder::class,
            CitiesTableSeeder::class,
            DistrictsTableSeeder::class,
            VillagesTableSeeder::class,
        ]);
    }
}
