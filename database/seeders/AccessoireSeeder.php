<?php

namespace Database\Seeders;

use App\Models\ObjetLouable;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class AccessoireSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nettoyage total pour repartir sur une base 100% propre
        $accessoireIds = ObjetLouable::where('type', 'bijoux')->pluck('id');
        Photo::whereIn('objet_louable_id', $accessoireIds)->delete();
        ObjetLouable::where('type', 'bijoux')->delete();

        // 2. Inventaire Visuel Validé (Mapping Photo -> Titre Complet)
        $data = [
            [
                'file' => '14.18.06',
                'titre' => 'Parure "Carré d\'Orient" (Collier & Boucles)',
                'desc' => 'Ensemble élégant comprenant un collier à pendentif carré émeraude et ses boucles d\'oreilles assorties en or rose.',
                'prix' => 210, 'matiere' => 'Or Rose', 'couleur' => 'Rose/Vert'
            ],
            [
                'file' => '14.18.12',
                'titre' => 'Grand Ensemble "Cascade Royale" (Choker, Collier & Boucles)',
                'desc' => 'Une parure majestueuse composée d\'un choker rigide, d\'un long collier à franges et de boucles d\'oreilles pendantes.',
                'prix' => 350, 'matiere' => 'Plaqué Or', 'couleur' => 'Doré'
            ],
            [
                'file' => '14.19.00',
                'titre' => 'Duo de Manchettes "Art Déco"',
                'desc' => 'Paire de bracelets larges dorés avec motifs géométriques et pierres vertes centrales.',
                'prix' => 140, 'matiere' => 'Métal Doré', 'couleur' => 'Vert/Doré'
            ],
            [
                'file' => '14.19.07',
                'titre' => 'Collier "Symphonie de Jade"',
                'desc' => 'Somptueux collier à 5 rangs de perles vertes reliés par des ornements dorés finement ciselés.',
                'prix' => 160, 'matiere' => 'Perles/Or', 'couleur' => 'Vert'
            ],
            [
                'file' => '14.21.10',
                'titre' => 'Set de Bagues & Boucles "Minimalisme"',
                'desc' => 'Assortiment de 4 bagues géométriques et d\'une boucle d\'oreille moderne en or rose scintillante.',
                'prix' => 110, 'matiere' => 'Or Rose', 'couleur' => 'Rose'
            ],
            [
                'file' => '14.34.57',
                'titre' => 'Parure "Larmes de Diamant" (Collier & Boucles)',
                'desc' => 'Collier cascade en cristaux brillants accompagné de ses boucles d\'oreilles puces assorties.',
                'prix' => 300, 'matiere' => 'Cristaux', 'couleur' => 'Argenté'
            ],
            [
                'file' => '14.38.22',
                'titre' => 'Boucles d\'Oreilles "Lustre de Cristal"',
                'desc' => 'Imposantes boucles d\'oreilles en forme de losange articulé, serties de zircons pour un éclat maximal.',
                'prix' => 120, 'matiere' => 'Zirconium', 'couleur' => 'Argenté'
            ],
            [
                'file' => '14.43.02',
                'titre' => 'Parure "Sultan" (Collier & Boucles)',
                'desc' => 'Pendentif traditionnel en or monté sur un cordon de soie vert émeraude, avec boucles d\'oreilles assorties.',
                'prix' => 130, 'matiere' => 'Soie/Or', 'couleur' => 'Vert/Doré'
            ],
            [
                'file' => '14.44.39',
                'titre' => 'Collier "Rivière de Lumière"',
                'desc' => 'Collier multi-rangs de cristaux alternant motifs circulaires et gouttes de lumière.',
                'prix' => 250, 'matiere' => 'Argent/Diamants', 'couleur' => 'Argenté'
            ],
            [
                'file' => '14.48.44 (1)',
                'titre' => 'Parure "Éclat Céleste" (Collier & Boucles)',
                'desc' => 'Collier asymétrique en diamants de synthèse et boucles d\'oreilles pendantes assorties.',
                'prix' => 200, 'matiere' => 'Argent 925', 'couleur' => 'Argenté'
            ],
            [
                'file' => '14.48.44',
                'titre' => 'Parure "Aube Rose" (Collier & Boucles)',
                'desc' => 'Collier en chaîne or rose avec pendentif ciselé et boucles d\'oreilles assorties avec perles.',
                'prix' => 160, 'matiere' => 'Or Rose', 'couleur' => 'Rose Doré'
            ],
            [
                'file' => '14.50.51',
                'titre' => 'Ensemble "Sultana" (Choker & Boucles)',
                'desc' => 'Ras-du-cou rigide avec médaillon central et boucles d\'oreilles style palais marocain.',
                'prix' => 170, 'matiere' => 'Or/Pierres', 'couleur' => 'Doré/Vert'
            ],
            [
                'file' => '14.58.45',
                'titre' => 'Duo de Bagues d\'Exception "Zellige"',
                'desc' => 'Deux bagues massives en or rose (une carrée, une octogonale) serties d\'une émeraude centrale.',
                'prix' => 120, 'matiere' => 'Or Rose', 'couleur' => 'Rose'
            ],
            [
                'file' => '15.05.59',
                'titre' => 'Set "Grelots Nomades" (Bagues & Bracelets)',
                'desc' => 'Ensemble de 3 bagues et 3 bracelets en or rose ornés de petites pampilles mobiles (coins).',
                'prix' => 140, 'matiere' => 'Or Rose', 'couleur' => 'Rose Doré'
            ],
            [
                'file' => '15.07.37',
                'titre' => 'Parure "Émeraude Royale" (Choker & Boucles)',
                'desc' => 'Choker 3 rangs serti d\'émeraudes et boucles d\'oreilles puces assorties en diamant de synthèse.',
                'prix' => 310, 'matiere' => 'Argent/Émeraude', 'couleur' => 'Vert/Argenté'
            ],
            [
                'file' => '15.15.52',
                'titre' => 'Bracelet "Serpent Royal" (Multi-pierres)',
                'desc' => 'Bracelet articulé serpent s\'enroulant sur le bras, serti de rubis, saphirs et émeraudes.',
                'prix' => 250, 'matiere' => 'Or/Pierres', 'couleur' => 'Multicolore'
            ],
            [
                'file' => '15.17.40',
                'titre' => 'Le Grand Plastron "Hizam" de Mariée',
                'desc' => 'Parure de buste complète (Collier, Bretelles et Ceinture) en or finement ciselé au Maalem.',
                'prix' => 550, 'matiere' => 'Or Pur', 'couleur' => 'Doré'
            ],
            [
                'file' => '15.19.34',
                'titre' => 'La Mdamma "Émeraude Impériale"',
                'desc' => 'Ceinture large sculptée en or, sertie de dômes d\'émeraudes magnifiques.',
                'prix' => 300, 'matiere' => 'Or/Émeraudes', 'couleur' => 'Doré'
            ],
            [
                'file' => '15.31.05',
                'titre' => 'Collier "Moussem" Perles & Émeraude',
                'desc' => 'Multi-rangs de perles d\'eau douce se terminant sur un pendentif émeraude massif.',
                'prix' => 190, 'matiere' => 'Perles/Or', 'couleur' => 'Blanc/Doré'
            ],
        ];

        $admin = User::where('email', 'test@example.com')->first();
        $userId = $admin ? $admin->id : 1;

        // 3. Création des objets et photos
        foreach ($data as $item) {
            $objet = ObjetLouable::create([
                'titre' => $item['titre'],
                'description' => $item['desc'],
                'prix' => $item['prix'],
                'matiere' => $item['matiere'],
                'couleur' => $item['couleur'],
                'user_id' => $userId,
                'type' => 'bijoux',
                'statut' => 'approuve',
                'localisation' => 'Fès, Maroc',
            ]);

            $filename = "WhatsApp Image 2026-04-18 at " . $item['file'] . ".jpeg";

            Photo::create([
                'objet_louable_id' => $objet->id,
                'url_photo' => 'photos/Accessoires/' . $filename,
                'description' => 'Vue détaillée de ' . $item['titre']
            ]);
        }
    }
}
