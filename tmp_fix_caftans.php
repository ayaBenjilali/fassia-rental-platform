<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ObjetLouable;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;

$caftans = ObjetLouable::where('type', 'caftan')->with('photos')->get();
$grouped = $caftans->groupBy('titre');

echo "Analysis:\n";
foreach ($grouped as $titre => $items) {
    echo "- $titre: " . $items->count() . " records\n";
}

echo "\nFixing...\n";

foreach ($grouped as $titre => $items) {
    if ($items->count() > 1) {
        $principal = $items->first();
        echo "Merging into principal ID: {$principal->id} ($titre)\n";
        
        foreach ($items->slice(1) as $doublon) {
            foreach ($doublon->photos as $photo) {
                $photo->objet_louable_id = $principal->id;
                $photo->save();
                echo "  Moved photo ID {$photo->id} to principal\n";
            }
            $doublon->delete();
            echo "  Deleted duplicate ID {$doublon->id}\n";
        }
    }
}

$finalCount = ObjetLouable::where('type', 'caftan')->count();
echo "\nFinal Distinct Caftan Count: $finalCount\n";

// Export for Seeder
$allCaftans = ObjetLouable::where('type', 'caftan')->with('photos')->get();
$seederData = [];
foreach ($allCaftans as $c) {
    $seederData[] = [
        'titre' => $c->titre,
        'description' => $c->description,
        'prix' => $c->prix,
        'localisation' => $c->localisation,
        'taille' => $c->taille,
        'couleur' => $c->couleur,
        'tissu' => $c->tissu,
        'photos' => $c->photos->pluck('url_photo')->toArray(),
    ];
}

file_put_contents('caftans_clean.json', json_encode($seederData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "\nClean data exported to caftans_clean.json\n";
