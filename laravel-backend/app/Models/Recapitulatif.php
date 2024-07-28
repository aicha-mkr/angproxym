<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recapitulatif extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'ventes_realisees',
        'clients_visites',
        'articles_vendus',
        'user_id',
    ];

    // Définit la relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
