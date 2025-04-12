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
        Schema::create('service_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('invoce')->nullable(); // Référence de la facture
            $table->datetime('date')->nullable(); // Date de début de la réservation
            $table->integer('nombre_personnes')->nullable(); // Nombre de personnes
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee', 'terminee'])->default('en_attente');
            // Statut de la réservation
            $table->decimal('montant_total', 8, 2)->nullable(); // Prix total de la réservation
            // Mode de paiement utilisé
            $table->text('note_client')->nullable(); // Optionnel : message ou note du client
            $table->string('nom_complet')->nullable(); // Optionnel : nom du client si pas inscrit
            $table->string('email')->nullable(); // Optionnel : email du client
            $table->string('telephone')->nullable(); // Optionnel : téléphone
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_reservations');
    }
};
