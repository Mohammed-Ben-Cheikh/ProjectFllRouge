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
        Schema::create('avis_chambers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('chamber_id')->constrained('chambres')->onDelete('cascade'); // Chambre
            $table->integer('note')->nullable(); // Note de l'avis
            $table->text('commentaire')->nullable(); // Commentaire de l'avis
            $table->enum('statut', ['en_attente', 'publie', 'refuse'])->default('en_attente'); // Statut de l'avis
            $table->timestamps();
        });

        Schema::create('avis_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Service
            $table->integer('note')->nullable(); // Note de l'avis
            $table->text('commentaire')->nullable(); // Commentaire de l'avis
            $table->enum('statut', ['en_attente', 'publie', 'refuse'])->default('en_attente'); // Statut de l'avis
            $table->timestamps();
        });

        Schema::create('avis_riads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('riad_id')->constrained('riads')->onDelete('cascade'); // Riad
            $table->integer('note')->nullable(); // Note de l'avis
            $table->text('commentaire')->nullable(); // Commentaire de l'avis
            $table->enum('statut', ['en_attente', 'publie', 'refuse'])->default('en_attente'); // Statut de l'avis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis_riad');
        Schema::dropIfExists('avis_service');
        Schema::dropIfExists('avis_chamber');
    }
};
