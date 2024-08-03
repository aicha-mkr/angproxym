<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ValomniaService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('VALOMNIA_BASE_URL', 'https://developers.valomnia.com/');
        $this->apiKey = env('VALOMNIA_API_KEY');
    }

    public function getOperations()
    {
        $endpoint = '/operations'; // Remplace par l'endpoint approprié de l'API Valomnia
        return $this->getData($endpoint);
    }

    public function getEmployees()
    {
        $endpoint = '/employees'; // Remplace par l'endpoint approprié de l'API Valomnia
        return $this->getData($endpoint);
    }

    private function getData($endpoint)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'application/json',
        ])->get($this->baseUrl . $endpoint);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function calculateKPI()
    {
        $operations = $this->getOperations();
        $employees = $this->getEmployees();

        if (!$operations || !$employees) {
            return null;
        }

        $totalRevenue = array_sum(array_column($operations, 'totalDiscounted'));
        $totalOrders = count(array_column($operations, 'reference'));
        $totalEmployees = count($employees);
        $averageSales = $totalRevenue / ($totalOrders ?: 1);

        return [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalEmployees' => $totalEmployees,
            'averageSales' => $averageSales,
        ];
    }
}
