<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommandation extends Model
{
    protected $fillable = [
        'score', 'user_id', 'objet_louable_id'
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
