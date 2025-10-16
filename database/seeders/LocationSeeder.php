<?php

namespace Database\Seeders;

use App\Models\JobOrder;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $jobOrders = JobOrder::all();

        $locationsData = [
            [
                'province' => 'DKI Jakarta',
                'province_id' => 6,
                'city' => 'Jakarta Selatan',
                'city_id' => 152,
                'district' => 'TEBET',
                'district_id' => 1369,
                'lat' => -6.2315,
                'lng' => 106.8306,
            ],
            [
                'province' => 'Jawa Barat',
                'province_id' => 9,
                'city' => 'Bandung',
                'city_id' => 23,
                'district' => 'Coblong',
                'district_id' => 2301,
                'lat' => -6.8915,
                'lng' => 107.6107,
            ],
            [
                'province' => 'Jawa Tengah',
                'province_id' => 10,
                'city' => 'Semarang',
                'city_id' => 501,
                'district' => 'Tembalang',
                'district_id' => 5013,
                'lat' => -7.0563,
                'lng' => 110.4397,
            ],
            [
                'province' => 'Jawa Timur',
                'province_id' => 11,
                'city' => 'Surabaya',
                'city_id' => 444,
                'district' => 'Rungkut',
                'district_id' => 4442,
                'lat' => -7.3190,
                'lng' => 112.7648,
            ],
            [
                'province' => 'Banten',
                'province_id' => 3,
                'city' => 'Tangerang',
                'city_id' => 39,
                'district' => 'Ciledug',
                'district_id' => 3905,
                'lat' => -6.2363,
                'lng' => 106.7092,
            ],
        ];

        foreach ($jobOrders as $jobOrder) {
            $pickup = $faker->randomElement($locationsData);
            $destination = $faker->randomElement($locationsData);

            Location::create([
                'job_order_id' => $jobOrder->id_job_order,
                'type' => 'pickup',
                'address' => $jobOrder->pickup_address,
                'province_id' => $pickup['province_id'],
                'city_id' => $pickup['city_id'],
                'district_id' => $pickup['district_id'],
                'province' => $pickup['province'],
                'city' => $pickup['city'],
                'district' => $pickup['district'],
                'lat' => $pickup['lat'],
                'lng' => $pickup['lng'],
            ]);

            Location::create([
                'job_order_id' => $jobOrder->id_job_order,
                'type' => 'destination',
                'address' => $jobOrder->destination_address,
                'province_id' => $destination['province_id'],
                'city_id' => $destination['city_id'],
                'district_id' => $destination['district_id'],
                'province' => $pickup['province'],
                'city' => $pickup['city'],
                'district' => $pickup['district'],
                'lat' => $destination['lat'],
                'lng' => $destination['lng'],
            ]);
        }
    }
}
