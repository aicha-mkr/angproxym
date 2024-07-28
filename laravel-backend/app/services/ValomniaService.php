<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ValomniaService
{
    public function getData($userId)
    {
        // hedha Exemple mta3 lappel API. juste badel l'URL réelle w les paramètres nécessaires.
        $response = Http::get('developers.valomnia.com/', [
            'user_id' => $userId,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
