<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.rajaongkir.base_url');
        $this->apiKey = config('services.rajaongkir.key');
    }

    public function getProvinces()
    {
        return Http::withHeaders(['key' => $this->apiKey])
            ->get("$this->baseUrl/province")
            ->json();
    }

    public function getCities($provinceId)
    {
        return Http::withHeaders(['key' => $this->apiKey])
            ->get("$this->baseUrl/city", ['province' => $provinceId])
            ->json();
    }

    public function getCost($origin, $destination, $weight, $courier = 'jne')
    {
        return Http::withHeaders(['key' => $this->apiKey])
            ->asForm()
            ->post("$this->baseUrl/cost", [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ])
            ->json();
    }
}
