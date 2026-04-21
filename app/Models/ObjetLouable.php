<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjetLouable extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'prix', 'localisation', 'user_id', 
        'type', 'taille', 'couleur', 'tissu', 'marque', 'matiere', 'statut'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }
}
