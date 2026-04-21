<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $fillable = [
        'url_photo', 'description', 'objet_louable_id'
    ];

    public function objetLouable(): BelongsTo
    {
        return $this->belongsTo(ObjetLouable::class);
    }
}
