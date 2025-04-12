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
            $table->string('nom')->unique(); // Nom de la chambre, unique
            $table->string('type')->nullable(); // Type de la chambre, nullable
            $table->string('description')->nullable(); // Description de la chambre, nullable
            $table->integer('prix')->nullable(); // Prix de la chambre, nullable
            $table->integer('nombre_lits')->nullable(); // Nombre de lits dans la chambre, nullable
            $table->integer('nombre_personnes')->nullable(); // Nombre de personnes pouvant séjourner dans la chambre, nullable
            $table->integer('surface')->nullable();
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
