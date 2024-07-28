<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Autres attributs et méthodes

    public function recapitulatifs()
    {
        return $this->hasMany(Recapitulatif::class);
    }
}


