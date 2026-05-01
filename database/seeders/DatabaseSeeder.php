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
        // Appel du seeder de synchronisation généré à partir de la BDD locale
        $this->call([
            SyncSeeder::class,
        ]);
        
        // Vous pouvez commenter/décommenter les autres seeders si besoin :
        /*
        $this->call([
            CaftanSeeder::class,
            AccessoireSeeder::class,
            SacSeeder::class,
            TalonSeeder::class,
        ]);
        */
    }
}
