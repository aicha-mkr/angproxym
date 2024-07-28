<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recapitulatif;
use App\Services\ValomniaService;
use Carbon\Carbon;

class RecapitulatifController extends Controller
{
    protected $valomniaService;

    public function __construct(ValomniaService $valomniaService)
    {
        $this->valomniaService = $valomniaService;
    }

    // Génération des récapitulatifs
    public function generateRecap()
    {
        $users = User::all(); // Assuming User model exists

        foreach ($users as $user) {
            $data = $this->valomniaService->fetchData($user->id);
            
            $recap = new Recapitulatif();
            $recap->user_id = $user->id;
            $recap->date = Carbon::now();
            $recap->total_orders = $data['total_orders'];
            $recap->total_revenue = $data['total_revenue'];
            $recap->average_sales = $data['average_sales'];
            $recap->total_quantities = $data['total_quantities'];
            $recap->total_clients = $data['total_clients'];
            $recap->save();
        }

        return response()->json(['message' => 'Récapitulatifs générés avec succès']);
    }

    
}
