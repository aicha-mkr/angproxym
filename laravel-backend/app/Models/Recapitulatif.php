<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recapitulatif extends Model
{
    // Indique la table associée au modèle
    protected $table = 'recapitulatifs';

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'user_id',
        'date',
        'total_orders',
        'total_revenue',
        'average_sales',
        'total_clients',
    ];

    // Les attributs qui devraient être traités comme des dates
    protected $dates = [
        'date',
    ];

    // Définir une relation avec le modèle User (si nécessaire)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthodes supplémentaires ou calculs
    public function getFormattedTotalRevenueAttribute()
    {
        return number_format($this->total_revenue, 2);
    }
}