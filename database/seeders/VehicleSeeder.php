<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'plate_number' => 'B 1234 SPK',
                'type' => 'Truck Box',
                'capacity' => 5000,
            ],
            [
                'plate_number' => 'B 5678 SPD',
                'type' => 'Pickup',
                'capacity' => 2000,
            ],
            [
                'plate_number' => 'L 4321 SPR',
                'type' => 'Van',
                'capacity' => 1500,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}
