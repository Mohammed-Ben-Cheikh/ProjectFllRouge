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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Lien avec l'utilisateur
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade'); // Lien avec la ville
        });

        Schema::table('riads', function (Blueprint $table) {
            $table->foreignId('riad_image_id')->constrained('riad_images')->onDelete('cascade'); // Lien avec l'image du riad, effacement en cascade si l'image est supprimée
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade'); // Lien avec l'entreprise
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade'); // Lien avec la ville
        });

        Schema::table('chambres', function (Blueprint $table) {
            $table->foreignId('riad_id')->constrained('riads')->onDelete('cascade'); // Lien avec le riad
            $table->foreignId('chambre_image_id')->constrained('chambre_images')->onDelete('cascade'); // Lien avec l'image de la chambre, effacement en cascade si l'image est supprimée
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('chambre_id')->constrained('chambres')->onDelete('cascade'); // Chambre
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('riad_id')->constrained('riads')->onDelete('cascade'); // Lien avec le riad
            $table->foreignId('service_image_id')->constrained('service_images')->onDelete('cascade'); // Lien avec l'image du service, effacement en cascade si l'image est supprimée
        });

        Schema::table('service_reservations', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Service
        });

        Schema::table('favoris_riads', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('riad_id')->constrained('riads')->onDelete('cascade'); // Riad
        });
        Schema::table('favoris_services', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Service
        });
        Schema::table('favoris_chambres', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('chambre_id')->constrained('chambres')->onDelete('cascade'); // Chambre
        });

        Schema::table('favoris_villes', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur
            $table->foreignId('ville_id')->constrained('villes')->onDelete('cascade'); // Ville
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ville_id']);
        });

        Schema::table('riads', function (Blueprint $table) {
            $table->dropForeign(['riad_image_id']);
            $table->dropForeign(['entreprise_id']);
            $table->dropForeign(['ville_id']);
        });

        Schema::table('chambres', function (Blueprint $table) {
            $table->dropForeign(['riad_id']);
            $table->dropForeign(['chambre_image_id']);
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['chambre_id']);
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['reservation_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['riad_id']);
            $table->dropForeign(['service_image_id']);
        });

        Schema::table('service_reservation', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['service_id']);
        });

        Schema::table('favoris_riads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['riad_id']);
        });

        Schema::table('favoris_services', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['service_id']);
        });

        Schema::table('favoris_chambres', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['chambre_id']);
        });

        Schema::table('favoris_villes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ville_id']);
        });
    }
};
