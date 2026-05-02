<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ObjetLouable;
use App\Models\Photo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SyncSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Users
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'nom' => 'Admin',
                'prenom' => 'Test',
                'role' => 'admin',
                'password' => Hash::make('12341234'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'ayabenjilali27@gmail.com'],
            [
                'name' => 'aya',
                'nom' => 'aya',
                'prenom' => 'aya',
                'role' => 'client',
                'password' => Hash::make('12341234'),
            ]
        );


        User::updateOrCreate(
            ['email' => 'elmehdilina39@gmail.com'],
            [
                'name' => 'lina',
                'nom' => 'el mehdi',
                'prenom' => 'lina',
                'role' => 'user',
                'password' => Hash::make('12341234'),
            ]
        );

        // Objets
        ObjetLouable::truncate();
        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 155,
                'user_id' => $user->id,
                'titre' => 'Caftan "Majesté Pourpre"',
                'description' => 'Incarnez la grâce et le mystère avec ce caftan d\'un prune profond absolument envoûtant. Réalisé dans un satin de soie luxueux.',
                'prix' => '550.00',
                'localisation' => 'FES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Prune',
                'tissu' => 'Satin de soie haute couture',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 156,
                'user_id' => $user->id,
                'titre' => 'Caftan "Sauge Royale"',
                'description' => 'Alliez noblesse et fraîcheur avec ce caftan en satin de soie vert sauge. Sublimé par des broderies artisanales ton sur ton.',
                'prix' => '500.00',
                'localisation' => 'MEKNES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Vert d\'eau',
                'tissu' => 'Satin de soie',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 157,
                'user_id' => $user->id,
                'titre' => 'Caftan "Émeraude & Or"',
                'description' => 'L\'alliance parfaite de la tradition et du luxe absolu. Velours émeraude épais orné de broderies dorées Maalem.',
                'prix' => '600.00',
                'localisation' => 'FES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Vert Émeraude / Or',
                'tissu' => 'Velours de soie (Mobra) haut de gamme',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 158,
                'user_id' => $user->id,
                'titre' => 'Caftan "Fleur de Menthe"',
                'description' => 'Douceur absolue en crêpe de soie vert menthe. Broderies florales ton sur ton et perlage délicat.',
                'prix' => '450.00',
                'localisation' => 'FES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Vert Menthe',
                'tissu' => 'Crêpe de soie',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 159,
                'user_id' => $user->id,
                'titre' => 'Caftan "Bronze Impérial"',
                'description' => 'Élégance à l\'état pur en velours chocolat profond. Broderies dorées Maalem majestueuses.',
                'prix' => '650.00',
                'localisation' => 'MEKNES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Chocolat profond / Bronze doré',
                'tissu' => 'Velours de soie (Mobra) de première qualité',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 160,
                'user_id' => $user->id,
                'titre' => 'Caftan "Nuit Boréale"',
                'description' => 'Élégance contemporaine en satin vert paon avec broderies argentées géométriques.',
                'prix' => '500.00',
                'localisation' => 'CASA',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Vert Paon',
                'tissu' => 'Satin de soie de luxe',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 161,
                'user_id' => $user->id,
                'titre' => 'Takchita "Éclat d\'Améthyste"',
                'description' => 'Luxe et raffinement en duo velours violet profond et satin améthyste.',
                'prix' => '700.00',
                'localisation' => 'CASA',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Violet Royal',
                'tissu' => 'Duo Velours de soie et Satin lourd',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 162,
                'user_id' => $user->id,
                'titre' => 'Caftan "Lumière Pastel"',
                'description' => 'Jaune pastel délicat et solaire en crêpe de soie léger. Broderies florales dorées.',
                'prix' => '450.00',
                'localisation' => 'MEKNES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Jaune Pastel',
                'tissu' => 'Crêpe de soie',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 163,
                'user_id' => $user->id,
                'titre' => 'Caftan "Éclat de Bronze"',
                'description' => 'Satin de soie bronze noble. Buste recouvert de broderies dorées Maalem rappelant les parures antiques.',
                'prix' => '550.00',
                'localisation' => 'RABAT',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Bronze',
                'tissu' => 'Satin de soie lourd au fini métallique',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 164,
                'user_id' => $user->id,
                'titre' => 'Caftan "Café de Nuit"',
                'description' => 'Velours chocolat noir avec col officier et ceinture dorée sculpturale. Élégance minimaliste.',
                'prix' => '600.00',
                'localisation' => 'RABAT',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Chocolat Noir',
                'tissu' => 'Velours de soie (Mobra) fini miroitant',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 165,
                'user_id' => $user->id,
                'titre' => 'Takchita "Aube Dorée"',
                'description' => 'Vieux rose délicat et satin cuivré. Broderies or Maalem et ceinture sculpturale.',
                'prix' => '500.00',
                'localisation' => 'FES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Vieux Rose',
                'tissu' => 'Duo Crêpe de soie et Satin irisé',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 166,
                'user_id' => $user->id,
                'titre' => 'Caftan "Rouge Rubis"',
                'description' => 'Rouge incandescent en soie jacquard avec motifs floraux tissés. Allure incendiaire.',
                'prix' => '500.00',
                'localisation' => 'TANGER',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Rouge Rubis',
                'tissu' => 'Soie Jacquard',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 167,
                'user_id' => $user->id,
                'titre' => 'Caftan "Soleil d\'Orient"',
                'description' => 'Jaune canari vibrant en crêpe de soie avec broderies florales blanc écru.',
                'prix' => '450.00',
                'localisation' => 'KENITRA',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Jaune Vif',
                'tissu' => 'Crêpe de soie',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 168,
                'user_id' => $user->id,
                'titre' => 'Caftan "Champagne Impérial"',
                'description' => 'Velours de soie champagne avec broderies artisanales dorées et ceinture sculpturale.',
                'prix' => '600.00',
                'localisation' => 'KENITRA',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Champagne',
                'tissu' => 'Velours de soie (Mobra) au fini miroitant',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 169,
                'user_id' => $user->id,
                'titre' => 'Caftan "Aurore de Velours"',
                'description' => 'Fusion velours fuchsia et jupe plissée soleil dorée. Silhouette modernité absolue.',
                'prix' => '750.00',
                'localisation' => 'CASA',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Fuchsia Profond',
                'tissu' => 'Velours de soie et Tissu métallique plissé',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 170,
                'user_id' => $user->id,
                'titre' => 'Caftan "Jardin d\'Oasis"',
                'description' => 'Velours de soie vert mousse avec broderies florales ton sur ton d\'une finesse incomparable.',
                'prix' => '600.00',
                'localisation' => 'MEKNES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Vert Mousse',
                'tissu' => 'Velours de soie (Mobra) haut de gamme',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 171,
                'user_id' => $user->id,
                'titre' => 'Caftan "Éclipse Royale"',
                'description' => 'Velours noir et jupe plissée soleil bronze antique. L\'invitation au glamour oriental.',
                'prix' => '750.00',
                'localisation' => 'RABAT',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Noir Intense',
                'tissu' => 'Velours de soie et Tissu métallique plissé',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 172,
                'user_id' => $user->id,
                'titre' => 'Takchita "Rêve d\'Azur"',
                'description' => 'Chiffon de soie bleu aqua léger avec broderies multicolores et dorées.',
                'prix' => '500.00',
                'localisation' => 'FES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Bleu Aqua',
                'tissu' => 'Duo Chiffon de soie et Satin fluide',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 173,
                'user_id' => $user->id,
                'titre' => 'Caftan "Rubis d\'Orient"',
                'description' => 'Crêpe de soie lourd bordeaux avec broderies or Maalem. Noblesse et distinction.',
                'prix' => '500.00',
                'localisation' => 'TANGER',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Bordeaux',
                'tissu' => 'Crêpe de soie lourd fini mat',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 174,
                'user_id' => $user->id,
                'titre' => 'Caftan "Éclat d\'Améthyste"',
                'description' => 'Soie satinée violet électrique avec broderies argentées géométriques et florales.',
                'prix' => '500.00',
                'localisation' => 'AGADIR',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Violet Électrique',
                'tissu' => 'Soie Satinée',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 175,
                'user_id' => $user->id,
                'titre' => 'Caftan "Douceur d\'Ivoire"',
                'description' => 'Crêpe de soie crème avec broderies magenta et bordeaux. Subtilité et raffinement.',
                'prix' => '450.00',
                'localisation' => 'AGADIR',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Crème',
                'tissu' => 'Crêpe de soie léger',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 176,
                'user_id' => $user->id,
                'titre' => 'Caftan "Éclat de Corail"',
                'description' => 'Rayonnez de fraîcheur avec ce caftan d\'un corail vibrant. Broderies géométriques ton sur ton.',
                'prix' => '450.00',
                'localisation' => 'MARRAKECH',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Corail',
                'tissu' => 'Crêpe de soie premium',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 177,
                'user_id' => $user->id,
                'titre' => 'Caftan "Brise Argentée"',
                'description' => 'Élégance discrète en bleu glacé. Broderies raffinées aux nuances argentées et lilas.',
                'prix' => '450.00',
                'localisation' => 'FES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Bleu glacé',
                'tissu' => 'Crêpe de soie premium',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 178,
                'user_id' => $user->id,
                'titre' => 'Caftan "Lumière Safran"',
                'description' => 'Éclatant et majestueux jaune safran avec de riches broderies vertes et dorées.',
                'prix' => '500.00',
                'localisation' => 'MEKNES',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Jaune safran',
                'tissu' => 'Crêpe de soie premium',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 179,
                'user_id' => $user->id,
                'titre' => 'Caftan "Émeraude Royale"',
                'description' => 'Fusion de noblesse et de fraîcheur émeraude. Silhouette fluide et broderies dorées.',
                'prix' => '480.00',
                'localisation' => 'CASA',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Vert Émeraude',
                'tissu' => 'Crêpe de soie premium',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 180,
                'user_id' => $user->id,
                'titre' => 'Caftan "Perle Dorée"',
                'description' => 'Sobre, chic et intemporel beige doré. Éclat discret pour une allure distinguée.',
                'prix' => '430.00',
                'localisation' => 'RABAT',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Beige doré',
                'tissu' => 'Satin de soie premium',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 181,
                'user_id' => $user->id,
                'titre' => 'Caftan "Neige Impériale"',
                'description' => 'Pur et spectaculaire blanc ivoire. Détails floraux en relief sur le bas de la robe.',
                'prix' => '550.00',
                'localisation' => 'TANGER',
                'type' => 'caftan',
                'taille' => 'Standard',
                'couleur' => 'Blanc ivoire',
                'tissu' => 'Crêpe premium finitions 3D',
                'marque' => '',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 182,
                'user_id' => $user->id,
                'titre' => 'Parure "Carré d\'Orient" (Collier & Boucles)',
                'description' => 'Ensemble élégant comprenant un collier à pendentif carré émeraude et ses boucles d\'oreilles assorties en or rose.',
                'prix' => '210.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Rose/Vert',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or Rose',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 183,
                'user_id' => $user->id,
                'titre' => 'Grand Ensemble "Cascade Royale" (Choker, Collier & Boucles)',
                'description' => 'Une parure majestueuse composée d\'un choker rigide, d\'un long collier à franges et de boucles d\'oreilles pendantes.',
                'prix' => '350.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Plaqué Or',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 184,
                'user_id' => $user->id,
                'titre' => 'Duo de Manchettes "Art Déco"',
                'description' => 'Paire de bracelets larges dorés avec motifs géométriques et pierres vertes centrales.',
                'prix' => '140.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Vert/Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Métal Doré',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 185,
                'user_id' => $user->id,
                'titre' => 'Collier "Symphonie de Jade"',
                'description' => 'Somptueux collier à 5 rangs de perles vertes reliés par des ornements dorés finement ciselés.',
                'prix' => '160.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Vert',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Perles/Or',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 186,
                'user_id' => $user->id,
                'titre' => 'Set de Bagues & Boucles "Minimalisme"',
                'description' => 'Assortiment de 4 bagues géométriques et d\'une boucle d\'oreille moderne en or rose scintillante.',
                'prix' => '110.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Rose',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or Rose',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 187,
                'user_id' => $user->id,
                'titre' => 'Parure "Larmes de Diamant" (Collier & Boucles)',
                'description' => 'Collier cascade en cristaux brillants accompagné de ses boucles d\'oreilles puces assorties.',
                'prix' => '300.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Argenté',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Cristaux',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 188,
                'user_id' => $user->id,
                'titre' => 'Boucles d\'Oreilles "Lustre de Cristal"',
                'description' => 'Imposantes boucles d\'oreilles en forme de losange articulé, serties de zircons pour un éclat maximal.',
                'prix' => '120.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Argenté',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Zirconium',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 189,
                'user_id' => $user->id,
                'titre' => 'Parure "Sultan" (Collier & Boucles)',
                'description' => 'Pendentif traditionnel en or monté sur un cordon de soie vert émeraude, avec boucles d\'oreilles assorties.',
                'prix' => '130.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Vert/Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Soie/Or',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 190,
                'user_id' => $user->id,
                'titre' => 'Collier "Rivière de Lumière"',
                'description' => 'Collier multi-rangs de cristaux alternant motifs circulaires et gouttes de lumière.',
                'prix' => '250.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Argenté',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Argent/Diamants',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 191,
                'user_id' => $user->id,
                'titre' => 'Parure "Éclat Céleste" (Collier & Boucles)',
                'description' => 'Collier asymétrique en diamants de synthèse et boucles d\'oreilles pendantes assorties.',
                'prix' => '200.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Argenté',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Argent 925',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 192,
                'user_id' => $user->id,
                'titre' => 'Parure "Aube Rose" (Collier & Boucles)',
                'description' => 'Collier en chaîne or rose avec pendentif ciselé et boucles d\'oreilles assorties avec perles.',
                'prix' => '160.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Rose Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or Rose',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 193,
                'user_id' => $user->id,
                'titre' => 'Ensemble "Sultana" (Choker & Boucles)',
                'description' => 'Ras-du-cou rigide avec médaillon central et boucles d\'oreilles style palais marocain.',
                'prix' => '170.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Doré/Vert',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or/Pierres',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 194,
                'user_id' => $user->id,
                'titre' => 'Duo de Bagues d\'Exception "Zellige"',
                'description' => 'Deux bagues massives en or rose (une carrée, une octogonale) serties d\'une émeraude centrale.',
                'prix' => '120.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Rose',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or Rose',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 195,
                'user_id' => $user->id,
                'titre' => 'Set "Grelots Nomades" (Bagues & Bracelets)',
                'description' => 'Ensemble de 3 bagues et 3 bracelets en or rose ornés de petites pampilles mobiles (coins).',
                'prix' => '140.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Rose Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or Rose',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 196,
                'user_id' => $user->id,
                'titre' => 'Parure "Émeraude Royale" (Choker & Boucles)',
                'description' => 'Choker 3 rangs serti d\'émeraudes et boucles d\'oreilles puces assorties en diamant de synthèse.',
                'prix' => '310.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Vert/Argenté',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Argent/Émeraude',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 197,
                'user_id' => $user->id,
                'titre' => 'Bracelet "Serpent Royal" (Multi-pierres)',
                'description' => 'Bracelet articulé serpent s\'enroulant sur le bras, serti de rubis, saphirs et émeraudes.',
                'prix' => '250.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Multicolore',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or/Pierres',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 198,
                'user_id' => $user->id,
                'titre' => 'Le Grand Plastron "Hizam" de Mariée',
                'description' => 'Parure de buste complète (Collier, Bretelles et Ceinture) en or finement ciselé au Maalem.',
                'prix' => '550.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or Pur',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 199,
                'user_id' => $user->id,
                'titre' => 'La Mdamma "Émeraude Impériale"',
                'description' => 'Ceinture large sculptée en or, sertie de dômes d\'émeraudes magnifiques.',
                'prix' => '300.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Or/Émeraudes',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 200,
                'user_id' => $user->id,
                'titre' => 'Collier "Moussem" Perles & Émeraude',
                'description' => 'Multi-rangs de perles d\'eau douce se terminant sur un pendentif émeraude massif.',
                'prix' => '190.00',
                'localisation' => 'Fès, Maroc',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => 'Blanc/Doré',
                'tissu' => '',
                'marque' => '',
                'matiere' => 'Perles/Or',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 201,
                'user_id' => $user->id,
                'titre' => 'Minaudière Papillon Argentée',
                'description' => 'Une pochette spectaculaire recouverte de paillettes argentées avec un grand papillon en cristaux sur le devant. Parfaite pour les grandes occasions.',
                'prix' => '150.00',
                'localisation' => 'AGADIR',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Argent',
                'tissu' => 'Glitter / Cristal',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 202,
                'user_id' => $user->id,
                'titre' => 'Sac Velvet Midnight Gold',
                'description' => 'Pochette en velours noir profond ornée d\'une branche de fleurs en cristaux dorés. L\'alliance parfaite du luxe et de la sobriété.',
                'prix' => '140.00',
                'localisation' => 'AGADIR',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Noir / Or',
                'tissu' => 'Velours',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 203,
                'user_id' => $user->id,
                'titre' => 'Sac à Perles Rubis',
                'description' => 'Un sac sculptural entièrement réalisé à la main avec des perles rouge rubis. Une touche de couleur vibrante pour vos tenues.',
                'prix' => '120.00',
                'localisation' => 'RABAT',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Rouge',
                'tissu' => 'Perles',
                'marque' => 'Handmade',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 204,
                'user_id' => $user->id,
                'titre' => 'Sac Perles de Pluie',
                'description' => 'Magnifique sac en perles blanches agrémenté de pampilles en cristal transparent qui rappellent des gouttes de rosée.',
                'prix' => '160.00',
                'localisation' => 'AGADIR',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Perle / Cristal',
                'tissu' => 'Perles',
                'marque' => 'Handmade',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 205,
                'user_id' => $user->id,
                'titre' => 'Pochette Brodée à Franges',
                'description' => 'Sac bandoulière en daim nude avec des broderies de perles complexes et des franges perlées en cascade.',
                'prix' => '130.00',
                'localisation' => 'AGADIR',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Nude / Beige',
                'tissu' => 'Daim / Perles',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 206,
                'user_id' => $user->id,
                'titre' => 'Minaudière Rose Gold Shimmer',
                'description' => 'Pochette rigide ovale à l\'éclat rose doré scintillant. Livrée avec une fine chaîne dorée élégante.',
                'prix' => '90.00',
                'localisation' => 'CASA',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Rose Gold',
                'tissu' => 'Paillettes',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 207,
                'user_id' => $user->id,
                'titre' => 'Clutch Crystal Split',
                'description' => 'Pochette bicolore : une moitié en paillettes champagne et l\'autre recouverte de gros cristaux facettés.',
                'prix' => '170.00',
                'localisation' => 'FES',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Champagne',
                'tissu' => 'Cristal / Paillettes',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 208,
                'user_id' => $user->id,
                'titre' => 'Sac Madame Chatelet Panther',
                'description' => 'Sac en cuir noir effet crocodile avec une poignée sculpturale représentant une panthère dorée bondissante. Un design audacieux.',
                'prix' => '220.00',
                'localisation' => 'CASA',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Noir / Or',
                'tissu' => 'Cuir Croco',
                'marque' => 'Madame Chatelet',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 209,
                'user_id' => $user->id,
                'titre' => 'Pochette Satin Diamond Arch',
                'description' => 'Sac soirée noir minimaliste en satin avec une anse rigide courbée entièrement pavée de diamants.',
                'prix' => '190.00',
                'localisation' => 'MARRAKECH',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Noir',
                'tissu' => 'Satin',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 210,
                'user_id' => $user->id,
                'titre' => 'Sac Tressé Nude Twisted',
                'description' => 'Sac en cuir tressé couleur crème avec une poignée en métal doré torsadé. Style iconique et moderne.',
                'prix' => '250.00',
                'localisation' => 'RABAT',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Crème',
                'tissu' => 'Cuir',
                'marque' => 'Bottega Style',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 211,
                'user_id' => $user->id,
                'titre' => 'Pochette Coquillage Nacrée',
                'description' => 'Clutch en forme de coquillage aux reflets holographiques nacrés. Clasp orné de deux perles géantes.',
                'prix' => '145.00',
                'localisation' => 'RABAT',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Nacre',
                'tissu' => 'Résine Nacrée',
                'marque' => 'Oceania',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 212,
                'user_id' => $user->id,
                'titre' => 'Bucket Bag Full Pearl',
                'description' => 'Sac seau entièrement recouvert de perles de différentes tailles. Anse anneau en métal argenté.',
                'prix' => '155.00',
                'localisation' => 'AGADIR',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Blanc Cassé',
                'tissu' => 'Perles',
                'marque' => 'Handmade',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 213,
                'user_id' => $user->id,
                'titre' => 'Half-Moon Burgundy Muse',
                'description' => 'Sac demi-lune en cuir verni bordeaux avec la célèbre poignée knot en métal doré.',
                'prix' => '210.00',
                'localisation' => 'FES',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Bordeaux',
                'tissu' => 'Cuir Verni',
                'marque' => 'Cult Gaia Style',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 214,
                'user_id' => $user->id,
                'titre' => 'Sac Asymétrique Alaïa Style',
                'description' => 'Magnifique pièce asymétrique en cuir bordeaux avec anse knot et charme pyramide doré.',
                'prix' => '240.00',
                'localisation' => 'TANGER',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Bordeaux',
                'tissu' => 'Cuir',
                'marque' => 'Alaïa Style',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 215,
                'user_id' => $user->id,
                'titre' => 'Sac Pétales Azur et Rose',
                'description' => 'Sac perlé bleu ciel orné de pétales en 3D dans des tons rose poudré et perles blanches. Un bijou de fraîcheur.',
                'prix' => '135.00',
                'localisation' => 'RABAT',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Bleu / Rose',
                'tissu' => 'Perles / Tissu',
                'marque' => 'Handmade',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 216,
                'user_id' => $user->id,
                'titre' => 'Sac Suede Orbite Tan',
                'description' => 'Sac en daim couleur caramel avec deux sphères dorées imposantes servant de points d\'attache à la poignée.',
                'prix' => '230.00',
                'localisation' => 'CASA',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Camel',
                'tissu' => 'Daim',
                'marque' => 'Jacquemus Style',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 217,
                'user_id' => $user->id,
                'titre' => 'Sac Glossy Navy U-Bar',
                'description' => 'Sac à main en cuir bleu marine brillant avec une barre dorée en U distinctive sur le rabat.',
                'prix' => '185.00',
                'localisation' => 'FES',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Bleu Marine',
                'tissu' => 'Cuir Verni',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 218,
                'user_id' => $user->id,
                'titre' => 'Sac Dark Coffee Knotted',
                'description' => 'Sac en cuir marron chocolat avec une poignée anneau doré et de multiples nœuds de cuir décoratifs.',
                'prix' => '200.00',
                'localisation' => 'RABAT',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Marron Foncé',
                'tissu' => 'Cuir',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 219,
                'user_id' => $user->id,
                'titre' => 'Ellipse Nude Rose',
                'description' => 'Sac de forme elliptique couleur vieux rose avec une poignée large et un fermoir doré en forme de feuille.',
                'prix' => '175.00',
                'localisation' => 'RABAT',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Vieux Rose',
                'tissu' => 'Cuir',
                'marque' => 'Fassia Luxe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 220,
                'user_id' => $user->id,
                'titre' => 'Sac Chanel Mint Croc',
                'description' => 'Sac structuré en cuir effet crocodile vert menthe avec cadre métallique doré et poignée élégante.',
                'prix' => '280.00',
                'localisation' => 'TANGER',
                'type' => 'sac',
                'taille' => '',
                'couleur' => 'Vert Menthe',
                'tissu' => 'Cuir Croco',
                'marque' => 'Chanel Style',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 221,
                'user_id' => $user->id,
                'titre' => 'Sandales YSL Opium Noires',
                'description' => 'Sandales Yves Saint Laurent avec le célèbre talon sculpté doré YSL. Le summum de l\'élégance audacieuse.',
                'prix' => '210.00',
                'localisation' => 'AGADIR',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Noir',
                'tissu' => 'Cuir Verni',
                'marque' => 'Yves Saint Laurent',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 222,
                'user_id' => $user->id,
                'titre' => 'Slingbacks Arezzo Bordeaux',
                'description' => 'Escarpins pointus Arezzo couleur bordeaux profond, avec de fines lanières entrecroisées élégantes.',
                'prix' => '220.00',
                'localisation' => 'FES',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Bordeaux',
                'tissu' => 'Vernis',
                'marque' => 'Arezzo',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 223,
                'user_id' => $user->id,
                'titre' => 'Escarpins Jimmy Choo en Dentelle',
                'description' => 'Sublimes escarpins Jimmy Choo recouverts de dentelle noire florale pour une touche romantique chic.',
                'prix' => '280.00',
                'localisation' => 'MARRAKECH',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Noir',
                'tissu' => 'Dentelle',
                'marque' => 'Jimmy Choo',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 224,
                'user_id' => $user->id,
                'titre' => 'Slingbacks Valentino Garavani',
                'description' => 'Escarpins noirs à talon haut ornés du grand logo VLogo doré de Valentino. Intérieur rouge contrastant.',
                'prix' => '320.00',
                'localisation' => 'MARRAKECH',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Noir',
                'tissu' => 'Cuir',
                'marque' => 'Valentino',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 225,
                'user_id' => $user->id,
                'titre' => 'Slingbacks Dior J\'Adior',
                'description' => 'Mules à talons en tissu technique texturé bordeaux avec le célèbre ruban brodé J\'ADIOR.',
                'prix' => '300.00',
                'localisation' => 'CASA',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Bordeaux',
                'tissu' => 'Tissu côtelé',
                'marque' => 'Dior',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 226,
                'user_id' => $user->id,
                'titre' => 'Escarpins Louboutin Nude',
                'description' => 'Les classiques indémodables : escarpins vernis couleur nude signés Christian Louboutin avec la semelle rouge.',
                'prix' => '190.00',
                'localisation' => 'TANGER',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Nude',
                'tissu' => 'Cuir Verni',
                'marque' => 'Christian Louboutin',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 227,
                'user_id' => $user->id,
                'titre' => 'Mules Uterqüe Bleues',
                'description' => 'Escarpins ouverts style denim bleu clair, mis en valeur par une spectaculaire boucle carrée en cristal.',
                'prix' => '240.00',
                'localisation' => 'FES',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Bleu',
                'tissu' => 'Denim',
                'marque' => 'Uterqüe',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 228,
                'user_id' => $user->id,
                'titre' => 'Sandales Bijoux Jimmy Choo',
                'description' => 'Sandales blanches de cérémonie lourdement ornées de sublimes cristaux transparents volumineux.',
                'prix' => '300.00',
                'localisation' => 'AGADIR',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Blanc',
                'tissu' => 'Cuir / Cristal',
                'marque' => 'Jimmy Choo',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 229,
                'user_id' => $user->id,
                'titre' => 'Sandales Wavy Louboutin',
                'description' => 'Talon aiguille vertigineux et fines lanières ondulées en cuir marron. Signé Christian Louboutin.',
                'prix' => '230.00',
                'localisation' => 'AGADIR',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Marron',
                'tissu' => 'Cuir',
                'marque' => 'Christian Louboutin',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 230,
                'user_id' => $user->id,
                'titre' => 'Sandales Spirale René Caovilla',
                'description' => 'Sandales jaunes uniques s\'enroulant autour de la cheville, décorées de superbes papillons en cristal.',
                'prix' => '220.00',
                'localisation' => 'AGADIR',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Jaune',
                'tissu' => 'Cuir / Cristal',
                'marque' => 'René Caovilla',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 231,
                'user_id' => $user->id,
                'titre' => 'Mules Jaunes à Talon Transparent',
                'description' => 'Mules au design épuré avec des brides rembourrées croisées jaunes et un talon acrylique transparent.',
                'prix' => '240.00',
                'localisation' => 'RABAT',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Jaune',
                'tissu' => 'Simili cuir',
                'marque' => 'Boutique Indépendante',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 232,
                'user_id' => $user->id,
                'titre' => 'Sandales Rouges Métallisées Louboutin',
                'description' => 'Sandales avec un effet miroir métallisé rouge intense et des brides asymétriques.',
                'prix' => '310.00',
                'localisation' => 'AGADIR',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Rouge',
                'tissu' => 'Vernis Métallisé',
                'marque' => 'Christian Louboutin',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 233,
                'user_id' => $user->id,
                'titre' => 'Sandales Velours et Plumes Versace',
                'description' => 'Talons hauts en velours bordeaux ornés d\'une luxueuse plume sur l\'avant et de la boucle Medusa dorée.',
                'prix' => '340.00',
                'localisation' => 'RABAT',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Bordeaux',
                'tissu' => 'Velours / Plumes',
                'marque' => 'Versace',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 234,
                'user_id' => $user->id,
                'titre' => 'Slingbacks YSL Vernis Noir',
                'description' => 'Le chic absolu. Des escarpins slingback noirs au vernis éclatant avec un bout extrêmement pointu par Saint Laurent.',
                'prix' => '270.00',
                'localisation' => 'TANGER',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Noir',
                'tissu' => 'Vernis',
                'marque' => 'Yves Saint Laurent',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 235,
                'user_id' => $user->id,
                'titre' => 'Sandales Florales Jimmy Choo',
                'description' => 'Magnifiques sandales blanches décorées de superbes fleurs dorées en 3D à l\'avant et sur le cou-de-pied.',
                'prix' => '380.00',
                'localisation' => 'AGADIR',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Blanc / Or',
                'tissu' => 'Satin',
                'marque' => 'Jimmy Choo',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 236,
                'user_id' => $user->id,
                'titre' => 'Escarpins Miroir Or',
                'description' => 'Des escarpins classiques revisités avec un revêtement doré effet miroir réfléchissant sensationnel.',
                'prix' => '210.00',
                'localisation' => 'FES',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Or',
                'tissu' => 'Métallisé',
                'marque' => 'Luxe Edition',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 237,
                'user_id' => $user->id,
                'titre' => 'Sandales noires à Chaîne Jimmy Choo',
                'description' => 'Sandales minimalistes noires sublimées par une très épaisse et luxueuse chaîne dorée enroulée à la cheville.',
                'prix' => '330.00',
                'localisation' => 'FES',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Noir',
                'tissu' => 'Cuir',
                'marque' => 'Jimmy Choo',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 238,
                'user_id' => $user->id,
                'titre' => 'Escarpins Bijoux Bordeaux Jimmy Choo',
                'description' => 'Satin bordeaux profond couronné d\'une chaîne de cheville lâche dégoulinante de diamants brillants.',
                'prix' => '390.00',
                'localisation' => 'FES',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Bordeaux',
                'tissu' => 'Satin',
                'marque' => 'Jimmy Choo',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 239,
                'user_id' => $user->id,
                'titre' => 'Escarpins Daim Rose Poudré Louboutin',
                'description' => 'Adoubez votre look avec ces escarpins en daim doux couleur rose pastel. Semelle rouge signature.',
                'prix' => '260.00',
                'localisation' => 'MARRAKECH',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Rose',
                'tissu' => 'Daim',
                'marque' => 'Christian Louboutin',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 240,
                'user_id' => $user->id,
                'titre' => 'Sandales Minimalistes Charles & Keith',
                'description' => 'Lignes ultra-fines marron chocolat contrastées par un splendide talon asymétrique sculpté en or métallique.',
                'prix' => '185.00',
                'localisation' => 'FES',
                'type' => 'talon',
                'taille' => '36,37,38,39,40',
                'couleur' => 'Marron',
                'tissu' => 'Simili cuir',
                'marque' => 'Charles & Keith',
                'matiere' => '',
                'statut' => 'approuve',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 241,
                'user_id' => $user->id,
                'titre' => 'test1',
                'description' => 'tester ddddd',
                'prix' => '50.00',
                'localisation' => 'fes',
                'type' => 'bijoux',
                'taille' => '',
                'couleur' => '',
                'tissu' => '',
                'marque' => '',
                'matiere' => '',
                'statut' => 'rejete',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'aya@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 242,
                'user_id' => $user->id,
                'titre' => 'test2',
                'description' => 'hdhhdhhdhdh',
                'prix' => '2333.00',
                'localisation' => 'casa',
                'type' => 'sac',
                'taille' => '',
                'couleur' => '',
                'tissu' => '',
                'marque' => '',
                'matiere' => '',
                'statut' => 'rejete',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'lina@gmail.com')->first();
        if ($user) {
            ObjetLouable::insert([
                'id' => 244,
                'user_id' => $user->id,
                'titre' => 'test4',
                'description' => 'ffffffffffffffffffffffffff',
                'prix' => '333.00',
                'localisation' => 'fes',
                'type' => 'sac',
                'taille' => '',
                'couleur' => '',
                'tissu' => '',
                'marque' => '',
                'matiere' => '',
                'statut' => 'rejete',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Photos
        Photo::truncate();
        Photo::insert([
            'objet_louable_id' => 155,
            'url_photo' => 'photos/QaMlls8tqsFSemCgyIEw3wsBevQbrqzTl1iD8y1f.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 155,
            'url_photo' => 'photos/GQKfOyCn2TLIRD8n3TdvKp2rX96WnJ6w85HqGM6f.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 156,
            'url_photo' => 'photos/Mhq2FTWxtE6t21UyRZnQZG8MCSyDwsdBnkIcIcZI.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 156,
            'url_photo' => 'photos/1h0MeYPZKr1Va1Fabqv3b1KI7xNpdL9sn5ZJv5RB.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 157,
            'url_photo' => 'photos/BiCkDbv1wNc4EGzRKLnUk0UFWmo3oVxrRtPwgjIu.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 157,
            'url_photo' => 'photos/EkIm7gPYlSN4dninWvrpjJHtolXjts1K18uBdNzt.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 158,
            'url_photo' => 'photos/Q5H3zJ3R481doTqgDhMZFSZ8nlrH39Q5iHXmW5Lp.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 158,
            'url_photo' => 'photos/8VjQudBLL4zinM8ST37Z4cgruRafRgSSGByQkKwU.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 159,
            'url_photo' => 'photos/6AdRnrucRs9f9FvUMUJ7XYL4TxkYbDfkYfMGWGp5.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 159,
            'url_photo' => 'photos/masjtQxEcCMcxxq5YOtxvAi0VTFTFxMBR5dLDb6z.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 160,
            'url_photo' => 'photos/ediiYgFPfff4CVuJqoQlOq3jAbV6AlXKJEKhEq2H.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 160,
            'url_photo' => 'photos/8tLSSMm5HwMcx4ShMYqsr44J38nAUMCGXwi09Hgi.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 161,
            'url_photo' => 'photos/9QlEx9AJOjQxHViC6y43JipooxY3n34BsPpBeHWA.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 161,
            'url_photo' => 'photos/6TMA3cyBAyKfPfA0SUrONvgvBIog4hvZphN35Vhd.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 162,
            'url_photo' => 'photos/QXQQicUpLT7uCVjIOt7FDDAQa9VorG0g7LYLGyLx.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 162,
            'url_photo' => 'photos/EiGITUNxemssdrdWvwfmucHibzkmhHPKZfDZS7tt.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 163,
            'url_photo' => 'photos/9EIbnWkc9XbFd6HGaf6YYcTIF94VHBA9LqammSMn.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 163,
            'url_photo' => 'photos/j0Qw0QT0gEcy9WujHIIYSFIrqz4GjYkuSAiNvNzW.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 164,
            'url_photo' => 'photos/i4vECOGPi953rwCJC7Km5SHtzVre8EMJhbfLoLaJ.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 164,
            'url_photo' => 'photos/l8u8zD0PIU03cvt6TI0HKh1T7YgGP1YtPHEobmm0.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 165,
            'url_photo' => 'photos/hin0PCA9A5Icbz9cy6xxyk3pQulHzukocqxDaue5.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 165,
            'url_photo' => 'photos/qw2m1rZaHHvxzOVlM1jzylzooUTq6HS2cMboBQms.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 166,
            'url_photo' => 'photos/YR00Y1Ld8ASXv0z42GoKlWWMAXek4afse6yCz8aa.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 166,
            'url_photo' => 'photos/uXcAfTTp8CJqiXkNn7yN2rO2RY0u6vv1bV3ZW5P4.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 167,
            'url_photo' => 'photos/jWOV2S9rag42oeMXoF6HKsDF9fm96maNWu2jEECX.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 167,
            'url_photo' => 'photos/SYaEcdAeWNv3Eo03PzoeyN6mQtlIRGvtwVUYRAUQ.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 168,
            'url_photo' => 'photos/DeOm5jpQ1XWYRbXZgVleMcCyv4GObMsp9L90k3RP.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 168,
            'url_photo' => 'photos/8GHBMEmY9EuMSy0Sw6TcbQfrTiMSJSvzZJTg1kby.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 169,
            'url_photo' => 'photos/zT2w4L19zWTHFQrYVTof7NMua5ni4pUGIwtCFxTU.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 169,
            'url_photo' => 'photos/uiqJeUxd2mcth20YDw5ahKcyH2UuHauzi5RwJGmf.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 170,
            'url_photo' => 'photos/EjbRKpWy35BDsg0bAnL13cC2vwgv73wbKGyvQNVx.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 170,
            'url_photo' => 'photos/Xr6s1qBa1EfItjjKto2UUAKdfJgjNB4zXyfrrkty.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 171,
            'url_photo' => 'photos/WoR6O3kJgzN7ttBBeEb2KAUaVlW9F980PCeGW6Np.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 171,
            'url_photo' => 'photos/UmyaNAZOoRKrX9ogvjCYdRa9Fy5ulc3zVNnxCBSP.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 172,
            'url_photo' => 'photos/Qkt4KOlBcMgML3L0BGcAMkFuwMqKy01adKEQ7kt9.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 172,
            'url_photo' => 'photos/B5dikgyuvrNO7Kvu1DSaLEIDldKGWsGNnzdj2xy1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 173,
            'url_photo' => 'photos/0y7YNM2fFIYsMSgoSNdDxSEtumoK8mvIDF3NATZ3.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 173,
            'url_photo' => 'photos/Z3bIouiBPKNrxk9LPOm6JivaAqbIc3TPAmEM7eNk.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 174,
            'url_photo' => 'photos/FsxgwngLnWBchOgyhFQodTENXKk2L4JAllQUROAE.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 174,
            'url_photo' => 'photos/Ahb3uVxE63P3xwPDXQNhifi88cWA9G1tWHA2mkTu.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 175,
            'url_photo' => 'photos/kVRmnJHWJ9rD5m3PjabVET5mnJiGuThgfYJgAORL.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 175,
            'url_photo' => 'photos/uzSS7t74QMuY0vRZkuI4rBBiMpwlbd6x4HSJ3bkS.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 175,
            'url_photo' => 'photos/3voVWJFjzxRreR4UmmgmpX58bm2sFQLYnBDU7i0Q.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 176,
            'url_photo' => 'photos/YmaazZO4NZ5DAko7eLdvErWXE8eDmw2RrR3Js4qY.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 176,
            'url_photo' => 'photos/hfOziRWdlObpKxCkf6mz9GKdHTfDERwfmylqK4Jr.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 177,
            'url_photo' => 'photos/v1K5Wz86CkFj9J8iyfVM3b2XOLhUdYLFBhQ540C1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 177,
            'url_photo' => 'photos/QpTUTPoWP3Drom3RL6TMF853EN4PpJd8G8z5xYl.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 178,
            'url_photo' => 'photos/WerURVMVX643eKPiavzyqqLh6BD6j2ItD8GXne79.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 178,
            'url_photo' => 'photos/z1BR98DPXH0lf7efS3K2qQGxNRez0pzTIFu5Hwgh.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 179,
            'url_photo' => 'photos/Lev0n5XeU9ZIXqV3hvDuj2SanckpvpYCS7ATvHCD.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 179,
            'url_photo' => 'photos/b1LVLs3wxChjhPFV9nEzd5TKFvtIxGBOAUdsxwMy.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 180,
            'url_photo' => 'photos/3voVWJFjzxRreR4UmmgmpX58bm2sFQLYnBDU7i0Q.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 180,
            'url_photo' => 'photos/rJJpoF8xEZ8Q3IGzJMuibERLZJsvGXcSnHpYNTKk.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 181,
            'url_photo' => 'photos/dDXe8YplTEPc5RVaBIYOctA508eepP90DwCw8KYp.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 181,
            'url_photo' => 'photos/VQkAR6vPeUdBA3T3RNhrLG7YcC70ItUxKbYj3CrO.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 182,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.18.06.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 183,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.18.12.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 184,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.19.00.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 185,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.19.07.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 186,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.21.10.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 187,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.34.57.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 188,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.38.22.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 189,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.43.02.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 190,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.44.39.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 191,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.48.44 (1).jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 192,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.48.44.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 193,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.50.51.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 194,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 14.58.45.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 195,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 15.05.59.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 196,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 15.07.37.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 197,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 15.15.52.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 198,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 15.17.40.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 199,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 15.19.34.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 200,
            'url_photo' => 'photos/Accessoires/WhatsApp Image 2026-04-18 at 15.31.05.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 201,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 14.48.35.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 202,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 14.53.50.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 203,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 14.54.57.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 204,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 14.57.46.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 205,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 14.59.36.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 206,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 15.00.35.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 207,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 15.03.02.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 208,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 15.04.41.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 209,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 15.06.32.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 210,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-18 at 15.08.19.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 211,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.32.32.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 212,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.38.53.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 213,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.39.08.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 214,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.40.28.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 215,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.43.19.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 216,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.48.32.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 217,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.50.06.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 218,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.53.24.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 219,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.54.51.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 220,
            'url_photo' => 'photos/Sac/WhatsApp Image 2026-04-19 at 18.57.18.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 221,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.23.28 (1).jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 222,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.23.28.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 223,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.26.40.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 224,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.27.50.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 225,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.29.15.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 226,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.34.28.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 227,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.37.13.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 228,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-18 at 21.46.37.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 229,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 17.59.43.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 230,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.01.04.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 231,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.03.34.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 232,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.05.36.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 233,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.06.41.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 234,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.09.22.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 235,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.12.38.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 236,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.14.43.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 237,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.18.39.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 238,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.19.52.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 239,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.20.52.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 240,
            'url_photo' => 'photos/Talons/WhatsApp Image 2026-04-19 at 18.24.16.jpeg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 241,
            'url_photo' => 'photos/sCuyIfpAvdn5wr8rnbgDV3AIRyy9h32JCSFBGNnL.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 242,
            'url_photo' => 'photos/HAMjZfxWp82ucEQZQ5v1qAmqoEiGqZ6bmbHNEIYo.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 243,
            'url_photo' => 'photos/Ve6rMF1ENIiA2OpHN4Mt7jsZZi9ySC9EeT8IkAya.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Photo::insert([
            'objet_louable_id' => 244,
            'url_photo' => 'photos/AUWBnCHJRrOWw1vIfD1tPtsYX4IdJDd89S0jdRIy.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
