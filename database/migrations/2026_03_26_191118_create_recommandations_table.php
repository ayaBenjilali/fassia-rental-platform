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
        Schema::create('recommandations', function (Blueprint $table) {
            $table->id();
            $table->decimal('score', 5, 2);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('objet_louable_id')->constrained('objet_louables')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommandations');
    }
};
