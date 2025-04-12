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
        Schema::create('paiement_services', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 8, 2)->nullable();
            $table->enum('mode_paiement', ['carte', 'paypal', 'espece', 'virement'])->nullable(); // Mode de paiement utilisé
            $table->enum('statut', ['en_attente', 'confirme', 'annule'])->default('en_attente'); // Statut du paiement
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_services');
    }
};
