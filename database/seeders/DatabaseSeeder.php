<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ObjetLouable;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // On crée l'administrateur de test s'il n'existe pas déjà
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Admin',
                'nom' => 'Admin',
                'prenom' => 'Test',
                'role' => 'admin',
                'password' => bcrypt('password'), // Mot de passe par défaut
            ]
        );

        // On lance le remplissage des accessoires de luxe
        $this->call([
            CaftanSeeder::class,
            AccessoireSeeder::class,
        ]);
    }
}
