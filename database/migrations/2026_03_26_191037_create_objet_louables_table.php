<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('objet_louables', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 8, 2);
            $table->string('localisation')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type');
            $table->string('taille')->nullable();
            $table->string('couleur')->nullable();
            $table->string('tissu')->nullable();
            $table->string('marque')->nullable();
            $table->string('matiere')->nullable();
            $table->string('statut')->default('actif'); // Annonce publiée ou cachée
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objet_louables');
    }
};
