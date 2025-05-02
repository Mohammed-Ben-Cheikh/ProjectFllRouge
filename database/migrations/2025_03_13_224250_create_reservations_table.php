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
            $table->string('invoce')->unique();
            $table->string('rib')->nullable();
            $table->boolean('has_payment_proof')->default(false);
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('nombre_personnes')->nullable();
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee', 'terminee'])->default('en_attente');
            $table->enum('mode_paiement', ['espece', 'virement'])->default('espece');
            $table->decimal('montant_total', 8, 2)->nullable();
            $table->text('note_client')->nullable();
            $table->string('nom_complet')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
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
