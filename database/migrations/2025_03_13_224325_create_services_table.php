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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            // Basic service information
            $table->string('name'); // Changed from unique() as same service names might exist in different riads
            $table->string('slug')->unique(); // Slug for the service, unique
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2)->nullable(); // Changed to decimal for better monetary precision
            $table->integer('duree_minutes')->nullable(); // More specific field name
            // Service classification
            $table->string('type')->nullable(); // e.g., 'spa', 'restaurant', 'excursion'
            $table->string('categorie')->nullable(); // e.g., 'wellness', 'dining', 'adventure'
            // Service details
            $table->string('unite_mesure')->nullable(); // e.g., 'per person', 'per session', 'per hour'
            $table->integer('capacite_max')->nullable(); // Maximum people that can book this service
            $table->boolean('reservation_requise');
            $table->time('heure_ouverture')->nullable();
            $table->time('heure_fermeture')->nullable();
            $table->json('jours_disponibles')->nullable(); // Days of week available as JSON array
            // Status and timestamps
            $table->enum('statut', ['available', 'unavailable', 'seasonal', 'pending'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
