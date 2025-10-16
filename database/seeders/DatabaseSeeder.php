<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            StatusJobOrderSeeder::class,
            VehicleSeeder::class,
            JobOrderSeeder::class,
            LocationSeeder::class,
            ManifestSeeder::class,
        ]);
    }

}
