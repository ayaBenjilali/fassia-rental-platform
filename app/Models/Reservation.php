<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'date_debut', 'date_fin', 'statut', 'montant_total', 'user_id', 'objet_louable_id',
        'nom', 'ville', 'telephone', 'adresse', 'cin'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function objetLouable(): BelongsTo
    {
        return $this->belongsTo(ObjetLouable::class);
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }
}
