<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $jobOrders = JobOrder::all();

        foreach ($jobOrders as $jobOrder) {
            Location::create([
                'job_order_id' => $jobOrder->id_job_order,
                'type' => 'pickup',
                'address' => $jobOrder->pickup_address,
                'lat' => $faker->latitude(-6.4, -6.9),
                'lng' => $faker->longitude(106.7, 107.1),
            ]);

            Location::create([
                'job_order_id' => $jobOrder->id_job_order,
                'type' => 'destination',
                'address' => $jobOrder->destination_address,
                'lat' => $faker->latitude(-7.0, -6.3),
                'lng' => $faker->longitude(106.6, 107.2),
            ]);
        }
    }
}
