<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui sont attribuables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    
    protected $fillable = [
        'name', 'email', 'password', 'recap_preferences'
    ];
    
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'recap_preferences' => 'array',
    ];
    



    /**
     * Les attributs cachés pour les tableaux.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à convertir en types de données natifs.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Définir la relation avec le modèle Recapitulatif.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recapitulatifs(): HasMany
    {
        return $this->hasMany(Recapitulatif::class);
    }
}
