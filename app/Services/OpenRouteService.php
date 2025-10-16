<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenRouteService
{
    protected string $baseUrl = 'https://api.openrouteservice.org/v2/directions/driving-car';

    public function getDistanceAndDuration(float $startLat, float $startLng, float $endLat, float $endLng): array
    {
        $response = Http::get($this->baseUrl, [
            'api_key' => env('ORS_API_KEY'),
            'start' => "{$startLng},{$startLat}",
            'end' => "{$endLng},{$endLat}",
        ]);

        if ($response->failed()) {
            throw new \Exception("ORS request failed: " . $response->body());
        }

        $data = $response->json();

        $segment = $data['features'][0]['properties']['segments'][0] ?? null;

        if (!$segment) {
            throw new \Exception("Invalid ORS response");
        }

        return [
            'distance_km' => round($segment['distance'] / 1000, 2),
            'duration_minutes' => round($segment['duration'] / 60, 2),
        ];
    }
}
