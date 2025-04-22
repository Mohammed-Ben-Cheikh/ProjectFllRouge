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
        Schema::create('riads', function (Blueprint $table) {
            $table->id(); // ID unique pour chaque riad
            $table->string('nom')->unique(); // Nom du riad, unique
            $table->string('slug')->unique(); // Slug unique pour le riad
            $table->boolean('status')->default(false); // Statut du riad, par défaut faux
            $table->string('adresse')->nullable(); // Adresse du riad, nullable si non fournie
            $table->string('telephone')->nullable(); // Numéro de téléphone, nullable
            $table->string('fax')->nullable(); // Numéro de fax, nullable
            $table->string('email')->nullable(); // Email du riad, nullable
            $table->string('description')->nullable(); // Description du riad, nullable
            $table->integer('total_chambres')->default(0); // Total de chambres dans le riad, avec valeur par défaut 0
            $table->timestamps(); // Ajout des colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riads');
    }
};
