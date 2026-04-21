<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjetLouableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'prix' => $this->faker->randomFloat(2, 50, 5000),
            'localisation' => $this->faker->city(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['caftan', 'bijou', 'sac', 'talon']),
            'taille' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'Unique']),
            'couleur' => $this->faker->safeColorName(),
            'tissu' => $this->faker->randomElement(['Soie', 'Velours', 'Coton', 'Dentelle']),
            'marque' => $this->faker->company(),
            'matiere' => $this->faker->word(),
            'statut' => $this->faker->randomElement(['actif', 'inactif']),
        ];
    }
}
