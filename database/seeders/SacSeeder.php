<?php

namespace Database\Seeders;

use App\Models\ObjetLouable;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SacSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyage pour éviter les doublons avec le type 'sac'
        Photo::whereHas('objetLouable', function($q) {
            $q->where('type', 'sac');
        })->delete();
        ObjetLouable::where('type', 'sac')->delete();

        $admin = User::where('email', 'test@example.com')->first();
        $userId = $admin ? $admin->id : 1;

        // Dossier contenant les photos de sacs
        $imagesPath = public_path('storage/photos/Sac');
        $filenames = [];
        if (is_dir($imagesPath)) {
            $files = File::files($imagesPath);
            foreach ($files as $file) {
                if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $filenames[] = $file->getFilename();
                }
            }
        }

        // Données spécifiques pour chaque image
        $specificData = [
            'WhatsApp Image 2026-04-18 at 14.48.35.jpeg' => [
                'titre' => 'Minaudière Papillon Argentée',
                'description' => "Une pochette spectaculaire recouverte de paillettes argentées avec un grand papillon en cristaux sur le devant. Parfaite pour les grandes occasions.",
                'prix' => 150, 'couleur' => 'Argent', 'tissu' => 'Glitter / Cristal', 'marque' => 'Fassia Luxe'
            ],

            'WhatsApp Image 2026-04-18 at 14.53.50.jpeg' => [
                'titre' => 'Sac Velvet Midnight Gold',
                'description' => "Pochette en velours noir profond ornée d'une branche de fleurs en cristaux dorés. L'alliance parfaite du luxe et de la sobriété.",
                'prix' => 140, 'couleur' => 'Noir / Or', 'tissu' => 'Velours', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-18 at 14.54.57.jpeg' => [
                'titre' => 'Sac à Perles Rubis',
                'description' => "Un sac sculptural entièrement réalisé à la main avec des perles rouge rubis. Une touche de couleur vibrante pour vos tenues.",
                'prix' => 120, 'couleur' => 'Rouge', 'tissu' => 'Perles', 'marque' => 'Handmade'
            ],
            'WhatsApp Image 2026-04-18 at 14.57.46.jpeg' => [
                'titre' => 'Sac Perles de Pluie',
                'description' => "Magnifique sac en perles blanches agrémenté de pampilles en cristal transparent qui rappellent des gouttes de rosée.",
                'prix' => 160, 'couleur' => 'Perle / Cristal', 'tissu' => 'Perles', 'marque' => 'Handmade'
            ],
            'WhatsApp Image 2026-04-18 at 14.59.36.jpeg' => [
                'titre' => 'Pochette Brodée à Franges',
                'description' => "Sac bandoulière en daim nude avec des broderies de perles complexes et des franges perlées en cascade.",
                'prix' => 130, 'couleur' => 'Nude / Beige', 'tissu' => 'Daim / Perles', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-18 at 15.00.35.jpeg' => [
                'titre' => 'Minaudière Rose Gold Shimmer',
                'description' => "Pochette rigide ovale à l'éclat rose doré scintillant. Livrée avec une fine chaîne dorée élégante.",
                'prix' => 90, 'couleur' => 'Rose Gold', 'tissu' => 'Paillettes', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-18 at 15.03.02.jpeg' => [
                'titre' => 'Clutch Crystal Split',
                'description' => "Pochette bicolore : une moitié en paillettes champagne et l'autre recouverte de gros cristaux facettés.",
                'prix' => 170, 'couleur' => 'Champagne', 'tissu' => 'Cristal / Paillettes', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-18 at 15.04.41.jpeg' => [
                'titre' => 'Sac Madame Chatelet Panther',
                'description' => "Sac en cuir noir effet crocodile avec une poignée sculpturale représentant une panthère dorée bondissante. Un design audacieux.",
                'prix' => 220, 'couleur' => 'Noir / Or', 'tissu' => 'Cuir Croco', 'marque' => 'Madame Chatelet'
            ],
            'WhatsApp Image 2026-04-18 at 15.06.32.jpeg' => [
                'titre' => 'Pochette Satin Diamond Arch',
                'description' => "Sac soirée noir minimaliste en satin avec une anse rigide courbée entièrement pavée de diamants.",
                'prix' => 190, 'couleur' => 'Noir', 'tissu' => 'Satin', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-18 at 15.08.19.jpeg' => [
                'titre' => 'Sac Tressé Nude Twisted',
                'description' => "Sac en cuir tressé couleur crème avec une poignée en métal doré torsadé. Style iconique et moderne.",
                'prix' => 250, 'couleur' => 'Crème', 'tissu' => 'Cuir', 'marque' => 'Bottega Style'
            ],
            'WhatsApp Image 2026-04-19 at 18.32.32.jpeg' => [
                'titre' => 'Pochette Coquillage Nacrée',
                'description' => "Clutch en forme de coquillage aux reflets holographiques nacrés. Clasp orné de deux perles géantes.",
                'prix' => 145, 'couleur' => 'Nacre', 'tissu' => 'Résine Nacrée', 'marque' => 'Oceania'
            ],
            'WhatsApp Image 2026-04-19 at 18.38.53.jpeg' => [
                'titre' => 'Bucket Bag Full Pearl',
                'description' => "Sac seau entièrement recouvert de perles de différentes tailles. Anse anneau en métal argenté.",
                'prix' => 155, 'couleur' => 'Blanc Cassé', 'tissu' => 'Perles', 'marque' => 'Handmade'
            ],
            'WhatsApp Image 2026-04-19 at 18.39.08.jpeg' => [
                'titre' => 'Half-Moon Burgundy Muse',
                'description' => "Sac demi-lune en cuir verni bordeaux avec la célèbre poignée knot en métal doré.",
                'prix' => 210, 'couleur' => 'Bordeaux', 'tissu' => 'Cuir Verni', 'marque' => 'Cult Gaia Style'
            ],
            'WhatsApp Image 2026-04-19 at 18.40.28.jpeg' => [
                'titre' => 'Sac Asymétrique Alaïa Style',
                'description' => "Magnifique pièce asymétrique en cuir bordeaux avec anse knot et charme pyramide doré.",
                'prix' => 240, 'couleur' => 'Bordeaux', 'tissu' => 'Cuir', 'marque' => 'Alaïa Style'
            ],
            'WhatsApp Image 2026-04-19 at 18.43.19.jpeg' => [
                'titre' => 'Sac Pétales Azur et Rose',
                'description' => "Sac perlé bleu ciel orné de pétales en 3D dans des tons rose poudré et perles blanches. Un bijou de fraîcheur.",
                'prix' => 135, 'couleur' => 'Bleu / Rose', 'tissu' => 'Perles / Tissu', 'marque' => 'Handmade'
            ],
            'WhatsApp Image 2026-04-19 at 18.48.32.jpeg' => [
                'titre' => 'Sac Suede Orbite Tan',
                'description' => "Sac en daim couleur caramel avec deux sphères dorées imposantes servant de points d'attache à la poignée.",
                'prix' => 230, 'couleur' => 'Camel', 'tissu' => 'Daim', 'marque' => 'Jacquemus Style'
            ],
            'WhatsApp Image 2026-04-19 at 18.50.06.jpeg' => [
                'titre' => 'Sac Glossy Navy U-Bar',
                'description' => "Sac à main en cuir bleu marine brillant avec une barre dorée en U distinctive sur le rabat.",
                'prix' => 185, 'couleur' => 'Bleu Marine', 'tissu' => 'Cuir Verni', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-19 at 18.53.24.jpeg' => [
                'titre' => 'Sac Dark Coffee Knotted',
                'description' => "Sac en cuir marron chocolat avec une poignée anneau doré et de multiples nœuds de cuir décoratifs.",
                'prix' => 200, 'couleur' => 'Marron Foncé', 'tissu' => 'Cuir', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-19 at 18.54.51.jpeg' => [
                'titre' => 'Ellipse Nude Rose',
                'description' => "Sac de forme elliptique couleur vieux rose avec une poignée large et un fermoir doré en forme de feuille.",
                'prix' => 175, 'couleur' => 'Vieux Rose', 'tissu' => 'Cuir', 'marque' => 'Fassia Luxe'
            ],
            'WhatsApp Image 2026-04-19 at 18.57.18.jpeg' => [
                'titre' => 'Sac Chanel Mint Croc',
                'description' => "Sac structuré en cuir effet crocodile vert menthe avec cadre métallique doré et poignée élégante.",
                'prix' => 280, 'couleur' => 'Vert Menthe', 'tissu' => 'Cuir Croco', 'marque' => 'Chanel Style'
            ]
        ];

        $villes = ['CASA', 'RABAT', 'MARRAKECH', 'TANGER', 'AGADIR', 'FES'];

        foreach ($filenames as $filename) {
            $baseData = $specificData[$filename] ?? [
                'titre' => 'Sac Élégant',
                'description' => 'Un accessoire indispensable pour compléter votre tenue.',
                'prix' => rand(100, 250),
                'couleur' => 'Multicolore',
                'tissu' => 'Mélange',
                'marque' => 'Luxe'
            ];

            $sac = ObjetLouable::create(array_merge($baseData, [
                'localisation' => $villes[array_rand($villes)],
                'user_id' => $userId,
                'type' => 'sac',
                'statut' => 'approuve',
            ]));

            Photo::create([
                'objet_louable_id' => $sac->id,
                'url_photo' => 'photos/Sac/' . $filename,
                'description' => 'Vue de ' . $sac->titre
            ]);
        }
    }
}
