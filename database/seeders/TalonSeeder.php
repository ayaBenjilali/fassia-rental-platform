<?php

namespace Database\Seeders;

use App\Models\ObjetLouable;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TalonSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyage pour éviter les doublons avec le type 'talon'
        Photo::whereHas('objetLouable', function($q) {
            $q->where('type', 'talon');
        })->delete();
        ObjetLouable::where('type', 'talon')->delete();

        $admin = User::where('email', 'test@example.com')->first();
        $userId = $admin ? $admin->id : 1;

        // Lecture dynamique du dossier photos/Talons pour récupérer automatiquement les fichiers
        $imagesPath = public_path('storage/photos/Talons');
        $filenames = [];
        if (is_dir($imagesPath)) {
            $files = \Illuminate\Support\Facades\File::files($imagesPath);
            foreach ($files as $file) {
                if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $filenames[] = $file->getFilename();
                }
            }
        }

        // Base de données précise et personnalisée pour chaque image spécifique !
        $specificData = [
            'WhatsApp Image 2026-04-18 at 21.23.28 (1).jpeg' => [
                'titre' => 'Sandales YSL Opium Noires',
                'description' => "Sandales Yves Saint Laurent avec le célèbre talon sculpté doré YSL. Le summum de l'élégance audacieuse.",
                'prix' => 210, 'couleur' => 'Noir', 'tissu' => 'Cuir Verni', 'marque' => 'Yves Saint Laurent'
            ],
            'WhatsApp Image 2026-04-18 at 21.23.28.jpeg' => [
                'titre' => 'Slingbacks Arezzo Bordeaux',
                'description' => "Escarpins pointus Arezzo couleur bordeaux profond, avec de fines lanières entrecroisées élégantes.",
                'prix' => 220, 'couleur' => 'Bordeaux', 'tissu' => 'Vernis', 'marque' => 'Arezzo'
            ],
            'WhatsApp Image 2026-04-18 at 21.26.40.jpeg' => [
                'titre' => 'Escarpins Jimmy Choo en Dentelle',
                'description' => "Sublimes escarpins Jimmy Choo recouverts de dentelle noire florale pour une touche romantique chic.",
                'prix' => 280, 'couleur' => 'Noir', 'tissu' => 'Dentelle', 'marque' => 'Jimmy Choo'
            ],
            'WhatsApp Image 2026-04-18 at 21.27.50.jpeg' => [
                'titre' => 'Slingbacks Valentino Garavani',
                'description' => "Escarpins noirs à talon haut ornés du grand logo VLogo doré de Valentino. Intérieur rouge contrastant.",
                'prix' => 320, 'couleur' => 'Noir', 'tissu' => 'Cuir', 'marque' => 'Valentino'
            ],
            'WhatsApp Image 2026-04-18 at 21.29.15.jpeg' => [
                'titre' => 'Slingbacks Dior J\'Adior',
                'description' => "Mules à talons en tissu technique texturé bordeaux avec le célèbre ruban brodé J'ADIOR.",
                'prix' => 300, 'couleur' => 'Bordeaux', 'tissu' => 'Tissu côtelé', 'marque' => 'Dior'
            ],
            'WhatsApp Image 2026-04-18 at 21.34.28.jpeg' => [
                'titre' => 'Escarpins Louboutin Nude',
                'description' => "Les classiques indémodables : escarpins vernis couleur nude signés Christian Louboutin avec la semelle rouge.",
                'prix' => 190, 'couleur' => 'Nude', 'tissu' => 'Cuir Verni', 'marque' => 'Christian Louboutin'
            ],
            'WhatsApp Image 2026-04-18 at 21.37.13.jpeg' => [
                'titre' => 'Mules Uterqüe Bleues',
                'description' => "Escarpins ouverts style denim bleu clair, mis en valeur par une spectaculaire boucle carrée en cristal.",
                'prix' => 240, 'couleur' => 'Bleu', 'tissu' => 'Denim', 'marque' => 'Uterqüe'
            ],
            'WhatsApp Image 2026-04-18 at 21.46.37.jpeg' => [
                'titre' => 'Sandales Bijoux Jimmy Choo',
                'description' => "Sandales blanches de cérémonie lourdement ornées de sublimes cristaux transparents volumineux.",
                'prix' => 300, 'couleur' => 'Blanc', 'tissu' => 'Cuir / Cristal', 'marque' => 'Jimmy Choo'
            ],
            'WhatsApp Image 2026-04-19 at 17.59.43.jpeg' => [
                'titre' => 'Sandales Wavy Louboutin',
                'description' => "Talon aiguille vertigineux et fines lanières ondulées en cuir marron. Signé Christian Louboutin.",
                'prix' => 230, 'couleur' => 'Marron', 'tissu' => 'Cuir', 'marque' => 'Christian Louboutin'
            ],
            'WhatsApp Image 2026-04-19 at 18.01.04.jpeg' => [
                'titre' => 'Sandales Spirale René Caovilla',
                'description' => "Sandales jaunes uniques s'enroulant autour de la cheville, décorées de superbes papillons en cristal.",
                'prix' => 220, 'couleur' => 'Jaune', 'tissu' => 'Cuir / Cristal', 'marque' => 'René Caovilla'
            ],
            'WhatsApp Image 2026-04-19 at 18.03.34.jpeg' => [
                'titre' => 'Mules Jaunes à Talon Transparent',
                'description' => "Mules au design épuré avec des brides rembourrées croisées jaunes et un talon acrylique transparent.",
                'prix' => 240, 'couleur' => 'Jaune', 'tissu' => 'Simili cuir', 'marque' => 'Boutique Indépendante'
            ],
            'WhatsApp Image 2026-04-19 at 18.05.36.jpeg' => [
                'titre' => 'Sandales Rouges Métallisées Louboutin',
                'description' => "Sandales avec un effet miroir métallisé rouge intense et des brides asymétriques.",
                'prix' => 310, 'couleur' => 'Rouge', 'tissu' => 'Vernis Métallisé', 'marque' => 'Christian Louboutin'
            ],
            'WhatsApp Image 2026-04-19 at 18.06.41.jpeg' => [
                'titre' => 'Sandales Velours et Plumes Versace',
                'description' => "Talons hauts en velours bordeaux ornés d'une luxueuse plume sur l'avant et de la boucle Medusa dorée.",
                'prix' => 340, 'couleur' => 'Bordeaux', 'tissu' => 'Velours / Plumes', 'marque' => 'Versace'
            ],
            'WhatsApp Image 2026-04-19 at 18.09.22.jpeg' => [
                'titre' => 'Slingbacks YSL Vernis Noir',
                'description' => "Le chic absolu. Des escarpins slingback noirs au vernis éclatant avec un bout extrêmement pointu par Saint Laurent.",
                'prix' => 270, 'couleur' => 'Noir', 'tissu' => 'Vernis', 'marque' => 'Yves Saint Laurent'
            ],
            'WhatsApp Image 2026-04-19 at 18.12.38.jpeg' => [
                'titre' => 'Sandales Florales Jimmy Choo',
                'description' => "Magnifiques sandales blanches décorées de superbes fleurs dorées en 3D à l'avant et sur le cou-de-pied.",
                'prix' => 380, 'couleur' => 'Blanc / Or', 'tissu' => 'Satin', 'marque' => 'Jimmy Choo'
            ],
            'WhatsApp Image 2026-04-19 at 18.14.43.jpeg' => [
                'titre' => 'Escarpins Miroir Or',
                'description' => "Des escarpins classiques revisités avec un revêtement doré effet miroir réfléchissant sensationnel.",
                'prix' => 210, 'couleur' => 'Or', 'tissu' => 'Métallisé', 'marque' => 'Luxe Edition'
            ],
            'WhatsApp Image 2026-04-19 at 18.18.39.jpeg' => [
                'titre' => 'Sandales noires à Chaîne Jimmy Choo',
                'description' => "Sandales minimalistes noires sublimées par une très épaisse et luxueuse chaîne dorée enroulée à la cheville.",
                'prix' => 330, 'couleur' => 'Noir', 'tissu' => 'Cuir', 'marque' => 'Jimmy Choo'
            ],
            'WhatsApp Image 2026-04-19 at 18.19.52.jpeg' => [
                'titre' => 'Escarpins Bijoux Bordeaux Jimmy Choo',
                'description' => "Satin bordeaux profond couronné d'une chaîne de cheville lâche dégoulinante de diamants brillants.",
                'prix' => 390, 'couleur' => 'Bordeaux', 'tissu' => 'Satin', 'marque' => 'Jimmy Choo'
            ],
            'WhatsApp Image 2026-04-19 at 18.20.52.jpeg' => [
                'titre' => 'Escarpins Daim Rose Poudré Louboutin',
                'description' => "Adoubez votre look avec ces escarpins en daim doux couleur rose pastel. Semelle rouge signature.",
                'prix' => 260, 'couleur' => 'Rose', 'tissu' => 'Daim', 'marque' => 'Christian Louboutin'
            ],
            'WhatsApp Image 2026-04-19 at 18.24.16.jpeg' => [
                'titre' => 'Sandales Minimalistes Charles & Keith',
                'description' => "Lignes ultra-fines marron chocolat contrastées par un splendide talon asymétrique sculpté en or métallique.",
                'prix' => 185, 'couleur' => 'Marron', 'tissu' => 'Simili cuir', 'marque' => 'Charles & Keith'
            ]
        ];

        // Liste des villes au hasard
        $villes = ['CASA', 'RABAT', 'MARRAKECH', 'TANGER', 'AGADIR', 'FES'];

        // Insérer chaque talon avec sa photo respective
        foreach ($filenames as $index => $filename) {
            
            // On récupère les données exactes si elles existent, sinon on met des données génériques au hasard
            if (isset($specificData[$filename])) {
                $baseData = $specificData[$filename];
            } else {
                $baseData = [
                    'titre' => 'Talon Élégant',
                    'description' => 'Talon idéal pour toutes vos cérémonies et soirées.',
                    'prix' => rand(100, 300),
                    'couleur' => 'Autre',
                    'tissu' => 'Mixte',
                    'marque' => 'Luxe'
                ];
            }

            // On fusionne avec la localisation, la taille et les champs techniques
            $talon = ObjetLouable::create(array_merge($baseData, [
                'localisation' => $villes[array_rand($villes)],
                'taille' => '36,37,38,39,40', 
                'user_id' => $userId,
                'type' => 'talon',
                'statut' => 'actif',
            ]));

            // Lier la photo au talon
            Photo::create([
                'objet_louable_id' => $talon->id,
                'url_photo' => 'photos/Talons/' . $filename,
                'description' => 'Vue de ' . $talon->titre
            ]);
        }
    }
}
