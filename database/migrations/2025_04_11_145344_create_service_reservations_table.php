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
            $table->string('invoice')->nullable();
            $table->string('rib')->nullable();
            $table->boolean('has_payment_proof')->default(false);
            $table->datetime('date')->nullable();
            $table->integer('nombre_personnes')->nullable();
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee', 'terminee'])->default('en_attente');
            $table->decimal('montant_total', 8, 2)->nullable();
            $table->enum('mode_paiement', ['espece', 'virement'])->default('espece');
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
        Schema::dropIfExists('service_reservations');
    }
};
