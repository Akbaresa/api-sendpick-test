<?php

namespace Database\Seeders;

use App\Models\StatusJobOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusJobOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'pending',
            'in_transit',
            'delivered',
            'cancelled',
        ];

        foreach ($statuses as $status) {
            StatusJobOrder::create([
                'status_job_order_name' => $status,
            ]);
        }
    }
}
