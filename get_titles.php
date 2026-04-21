<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ObjetLouable;
use Illuminate\Support\Facades\DB;

$titles = ObjetLouable::where('type', 'caftan')
    ->where('titre', 'not like', '%consequatur%')
    ->where('titre', 'not like', '%quia%')
    ->where('titre', 'not like', '%libero%')
    ->where('titre', 'not like', '%et quia%')
    ->orderBy('titre')
    ->pluck('titre')
    ->unique();

echo "Unique Real Titles Count: " . $titles->count() . "\n";
foreach ($titles as $t) {
    echo "- $t\n";
}
