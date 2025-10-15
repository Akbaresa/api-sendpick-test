<?php

namespace Database\Seeders;

use App\Models\JobOrder;
use App\Models\StatusJobOrder;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $statuses = StatusJobOrder::pluck('id_status_job_order')->toArray();
        $drivers = User::whereHas('role', fn($q) => $q->where('role_name', 'driver'))
            ->pluck('id_user')
            ->toArray();
        $vehicles = Vehicle::pluck('id_vehicle')->toArray();

        for ($i = 1; $i <= 100; $i++) {
            JobOrder::create([
                'job_number' => 'JO-' . strtoupper(Str::random(6)),
                'customer_name' => $faker->name(),
                'pickup_address' => $faker->address(),
                'destination_address' => $faker->address(),
                'status_job_order_id' => $faker->randomElement($statuses),
                'driver_id' => $faker->randomElement($drivers),
                'vehicle_id' => $faker->randomElement($vehicles),
                'total_weight' => $faker->randomFloat(2, 100, 5000),
                'total_volume' => $faker->randomFloat(2, 1, 100),
            ]);
        }
    }
}
