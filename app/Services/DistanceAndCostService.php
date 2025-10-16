<?php

namespace App\Services;

use App\Models\Location;
use App\Models\JobOrder;

class DistanceAndCostService
{
    public function calculateForJobOrder($id)
    {
        $jobOrder = JobOrder::findOrFail($id);

        $pickup = Location::where('job_order_id', $id)->where('type', 'pickup')->first();
        $destination = Location::where('job_order_id', $id)->where('type', 'destination')->first();

        if (!$pickup || !$destination) {
            throw new \Exception('Pickup atau destination tidak ditemukan.');
        }

        $ors = new OpenRouteService();
        $distanceData = $ors->getDistanceAndDuration(
            (float) $pickup->lat,
            (float) $pickup->lng,
            (float) $destination->lat,
            (float) $destination->lng
        );

        $rajaOngkir = new RajaOngkirService();

        $originDistrict = $pickup->district_id ?? 1361;
        $destinationDistrict = $destination->district_id ?? 1370;
        $weight = max(1, $jobOrder->total_weight);

        $costResponse = $rajaOngkir->getDomesticCost($originDistrict, $destinationDistrict, $weight);

        return [
            'distance' => $distanceData,
            'cost' => $costResponse['data'] ?? [],
        ];
    }
}
