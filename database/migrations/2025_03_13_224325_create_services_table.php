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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2)->nullable();
            $table->integer('duree_minutes')->nullable();
            $table->string('type')->nullable();
            $table->string('categorie')->nullable();
            $table->string('unite_mesure')->nullable();
            $table->integer('capacite_max')->nullable();
            $table->boolean('reservation_requise');
            $table->time('heure_ouverture')->nullable();
            $table->time('heure_fermeture')->nullable();
            $table->json('jours_disponibles')->nullable();
            $table->integer('rating')->nullable();
            $table->enum('statut', ['available', 'unavailable', 'seasonal', 'pending'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
