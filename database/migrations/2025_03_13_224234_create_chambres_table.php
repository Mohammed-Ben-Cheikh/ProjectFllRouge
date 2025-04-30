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
        Schema::create('chambres', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de la chambre
            $table->string('slug')->unique(); // Slug de la chambre, unique
            $table->string('nombre'); // Nom de la chambre, unique
            $table->string('city'); // Ville de la chambre
            $table->enum('type', ['standard', 'deluxe', 'suite']); // Type de la chambre,
            $table->string('description')->nullable(); // Description de la chambre, nullable
            $table->json('equipements')->nullable(); // Equipements de la chambre, nullable
            $table->integer('prix')->nullable(); // Prix de la chambre, nullable
            $table->integer('nombre_lits')->nullable(); // Nombre de lits dans la chambre, nullable
            $table->json('capacity')->nullable(); // Nombre de personnes pouvant séjourner dans la chambre, nullable
            $table->decimal('surface',8,2)->nullable();
            $table->enum('statut', ['available', 'unavailable', 'booked'])->default('available'); // Statut de la chambre, par défaut 'available'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};
