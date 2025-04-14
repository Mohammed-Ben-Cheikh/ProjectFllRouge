<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // Nom de l'entreprise
            $table->string('slug')->unique(); // slug de l'entreprise
            $table->boolean('status')->default(false);
            $table->string('type')->nullable(); // Type de l'entreprise
            $table->string('adresse')->nullable(); // Adresse de l'entreprise
            $table->string('telephone')->nullable(); // Numéro de téléphone
            $table->string('fax')->nullable(); // Numéro de fax
            $table->string('email')->nullable(); // Email de l'entreprise
            $table->string('site_web')->nullable(); // URL du site web
            $table->string('description')->nullable(); // Description de l'entreprise
            $table->string('image')->nullable(); // Image de l'entreprise
            $table->integer('total_riads')->default(0); // Nombre total de riads
            $table->boolean('destroy')->default(false);
            $table->timestamps(); // Création des colonnes `created_at` et `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
