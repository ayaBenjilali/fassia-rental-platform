<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avis extends Model
{
    protected $fillable = [
        'note', 'commentaire', 'user_id', 'objet_louable_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function objetLouable(): BelongsTo
    {
        return $this->belongsTo(ObjetLouable::class);
    }
}
