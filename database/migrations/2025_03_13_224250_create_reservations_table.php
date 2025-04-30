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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('invoce')->unique(); // Référence de la facture
            $table->date('date_debut')->nullable(); // Date de début de la réservation
            $table->date('date_fin')->nullable(); // Date de fin de la réservation
            $table->integer('nombre_personnes')->nullable(); // Nombre de personnes
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee', 'terminee'])->default('en_attente');
            $table->enum('mode_paiement', ['carte', 'paypal', 'espece', 'virement'])->default('espece'); // Mode de paiement utilisé
            $table->decimal('montant_total', 8, 2)->nullable(); // Prix total de la réservation
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
        Schema::dropIfExists('reservations');
    }
};
