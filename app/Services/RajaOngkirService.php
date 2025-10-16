<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.rajaongkir.base_url', env('RAJAONGKIR_BASE_URL'));
        $this->apiKey = config('services.rajaongkir.key', env('RAJAONGKIR_API_KEY'));
    }

    /**
     * Ambil daftar district (kecamatan) berdasarkan city_id
     * GET https://rajaongkir.komerce.id/api/v1/destination/district/{city_id}
     */
    public function getDistrictsByCity(int $cityId): array
    {
        $response = Http::withHeaders([
            'Key' => $this->apiKey,
        ])->get("{$this->baseUrl}/destination/district/{$cityId}");

        if ($response->failed()) {
            throw new \Exception("Failed to fetch districts: " . $response->body());
        }

        return $response->json()['data'] ?? [];
    }

    /**
     * Hitung ongkir antar district
     * POST https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost
     */
    public function getDomesticCost(
        int $originDistrictId,
        int $destinationDistrictId,
        int $weight,
        string $couriers = 'jne:sicepat:jnt:anteraja:tiki:pos'
    ): array {
        $response = Http::withHeaders([
            'Key' => $this->apiKey,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post("{$this->baseUrl}/calculate/district/domestic-cost", [
            'origin' => $originDistrictId,
            'destination' => $destinationDistrictId,
            'weight' => $weight,
            'courier' => $couriers,
            'price' => 'lowest',
        ]);

        if ($response->failed()) {
            throw new \Exception("Failed to calculate cost: " . $response->body());
        }

        return $response->json();
    }
}
