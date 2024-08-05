<?php

namespace App\Http\Controllers;

use App\Models\Recapitulatif; // Importation du modèle Recapitulatif
use App\Services\ValomniaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecapitulatifController extends Controller
{
    protected $valomniaService;

    public function __construct(ValomniaService $valomniaService)
    {
        $this->valomniaService = $valomniaService;
    }

    public function generateRecapitulatifs()
    {
        // Assurez-vous que l'utilisateur est authentifié
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Appel du service pour obtenir les KPIs
        $kpis = $this->valomniaService->calculateKPI();

        // Vérifiez si les KPIs sont renvoyés correctement
        if (!$kpis) {
            return response()->json(['error' => 'Failed to fetch data from Valomnia API'], 500);
        }

        // Enregistrez les récapitulatifs dans la base de données
        $recap = new Recapitulatif();
        $recap->user_id = Auth::id(); // Utilisez Auth::id() pour obtenir l'ID de l'utilisateur authentifié
        $recap->date = now();
        $recap->total_orders = $kpis['totalOrders'] ?? 0; // Assurez-vous que les clés existent dans $kpis
        $recap->total_revenue = $kpis['totalRevenue'] ?? 0;
        $recap->average_sales = $kpis['averageSales'] ?? 0;
        $recap->total_clients = $kpis['totalEmployees'] ?? 0;
        $recap->save();

        return response()->json(['message' => 'Recapitulative generated successfully']);
    }
}