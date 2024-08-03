<?php

namespace App\Http\Controllers;

use App\Services\ValomniaService;
use Illuminate\Http\Request;

class RecapitulatifController extends Controller
{
    protected $valomniaService;

    public function __construct(ValomniaService $valomniaService)
    {
        $this->valomniaService = $valomniaService;
    }

    public function generateRecapitulatifs()
    {
        $kpis = $this->valomniaService->calculateKPI();

        if (!$kpis) {
            return response()->json(['error' => 'Failed to fetch data from Valomnia API'], 500);
        }

        // Logique pour enregistrer les récapitulatifs dans la base de données
        // Exemple simple de stockage, à adapter selon ton modèle
        $recap = new Recapitulatif();
        $recap->user_id = auth()->user()->id;
        $recap->date = now();
        $recap->total_orders = $kpis['totalOrders'];
        $recap->total_revenue = $kpis['totalRevenue'];
        $recap->average_sales = $kpis['averageSales'];
        $recap->total_clients = $kpis['totalEmployees'];
        $recap->save();

        return response()->json(['message' => 'Recapitulative generated successfully']);
    }
}
