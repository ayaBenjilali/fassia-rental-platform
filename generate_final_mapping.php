<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ObjetLouable;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;

$realTitles = [
    'Caftan "Aurore de Velours"', 'Caftan "Brise Argentée"', 'Caftan "Bronze Impérial"', 
    'Caftan "Café de Nuit"', 'Caftan "Champagne Impérial"', 'Caftan "Douceur d\'Ivoire"', 
    'Caftan "Éclat d\'Améthyste"', 'Caftan "Éclat de Bronze"', 'Caftan "Éclat de Corail"', 
    'Caftan "Éclipse Royale"', 'Caftan "Émeraude & Or"', 'Caftan "Émeraude Royale"', 
    'Caftan "Fleur de Menthe"', 'Caftan "Jardin d\'Oasis"', 'Caftan "Lumière Pastel"', 
    'Caftan "Lumière Safran"', 'Caftan "Majesté Pourpre"', 'Caftan "Neige Impériale"', 
    'Caftan "Nuit Boréale"', 'Caftan "Perle Dorée"', 'Caftan "Rouge Rubis"', 
    'Caftan "Rubis d\'Orient"', 'Caftan "Sauge Royale"', 'Caftan "Soleil d\'Orient"', 
    'Takchita "Aube Dorée"', 'Takchita "Éclat d\'Améthyste"', 'Takchita "Rêve d\'Azur"'
];

$mapping = [];

foreach ($realTitles as $title) {
    // On cherche tous les objets qui ont ce titre (indépendamment de l'encodage)
    $cleanTitle = str_replace('"', '', $title);
    $objs = ObjetLouable::where('titre', 'like', "%$cleanTitle%")
        ->orWhere('titre', 'like', '%' . json_encode($title) . '%')
        ->with('photos')
        ->get();
    
    $photos = [];
    $data = null;
    
    foreach ($objs as $obj) {
        if (!$data) $data = $obj;
        foreach ($obj->photos as $p) {
            $photos[] = $p->url_photo;
        }
    }
    
    // Si on a moins de 2 photos, on va chercher dans les "poubelles" ou par couleur
    if (count($photos) < 2 && $data) {
        // Recherche étendue par description ou couleur si besoin...
    }

    $mapping[] = [
        'titre' => $title,
        'description' => $data ? $data->description : '',
        'prix' => $data ? $data->prix : 500,
        'localisation' => $data ? $data->localisation : 'Fès',
        'taille' => $data ? $data->taille : 'Standard',
        'couleur' => $data ? $data->couleur : '',
        'tissu' => $data ? $data->tissu : '',
        'photos' => array_unique($photos)
    ];
}

file_put_contents('caftans_final_mapping.json', json_encode($mapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Mapping généré pour " . count($mapping) . " caftans.\n";
