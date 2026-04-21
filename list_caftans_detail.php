<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ObjetLouable;
use App\Models\Photo;

$caftans = ObjetLouable::where('type', 'caftan')->with('photos')->get();

foreach ($caftans as $c) {
    echo "ID: {$c->id} | Titre: {$c->titre} | Photos: " . $c->photos->count() . "\n";
    foreach ($c->photos as $p) {
        echo "  - Photo ID: {$p->id} | URL: {$p->url_photo}\n";
    }
    echo "--------------------------------------------------\n";
}
