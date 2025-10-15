<?php

namespace Database\Seeders;

use App\Models\JobOrder;
use App\Models\Manifest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManifestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $jobOrders = JobOrder::all();

        foreach ($jobOrders as $jobOrder) {
            $manifestCount = rand(2, 5);

            for ($i = 0; $i < $manifestCount; $i++) {
                Manifest::create([
                    'job_order_id' => $jobOrder->id_job_order,
                    'item_name' => $faker->words(rand(1, 3), true),
                    'quantity' => $faker->numberBetween(1, 20),
                    'weight' => $faker->randomFloat(2, 1, 500),
                    'volume' => $faker->randomFloat(2, 0.5, 50),
                    'notes' => $faker->boolean(30) ? $faker->sentence() : null,
                ]);
            }
        }
    }
}
