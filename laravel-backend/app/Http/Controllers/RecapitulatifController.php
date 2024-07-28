<?php

namespace App\Http\Controllers;

use App\Models\Recapitulatif;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ValomniaService;
use App\Notifications\RecapSentNotification;

class RecapitulatifController extends Controller
{
    protected $valomniaService;

    public function __construct(ValomniaService $valomniaService)
    {
        $this->valomniaService = $valomniaService;
    }

    public function index()
    {
        // Logique pour obtenir les récapitulatifs
        $recapitulatifs = Recapitulatif::all();
        return response()->json($recapitulatifs);
    }

    public function generateRecap($userId)
    {
        // Logique pour générer un récapitulatif pour un utilisateur donné
        // Appel à l'API externe Valomnia, génération de récapitulatif, etc.
        $recap = // logique de génération
        return response()->json($recap);
    }

    public function generateRecap(int $userId)
    {
        $user = User::findOrFail($userId);
        $data = $this->valomniaService->getData($userId);

        if ($data) {
            $recapitulatif = Recapitulatif::create([
                'date' => now(),
                'ventes_realisees' => $data['ventes_realisees'],
                'clients_visites' => $data['clients_visites'],
                'articles_vendus' => $data['articles_vendus'],
                'user_id' => $user->id,
            ]);

            // Envoyer la notification
            $user->notify(new RecapSentNotification());

            return response()->json($recapitulatif);
        }

        return response()->json(['error' => 'Failed to fetch data from external API'], 500);
    }
}
