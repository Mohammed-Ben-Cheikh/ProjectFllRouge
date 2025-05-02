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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('chamber_id')->constrained('chambres')->onDelete('cascade');
            $table->integer('note')->nullable();
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['en_attente', 'publie', 'refuse'])->default('en_attente');
            $table->timestamps();
        });

        Schema::create('avis_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->integer('note')->nullable();
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['en_attente', 'publie', 'refuse'])->default('en_attente');
            $table->timestamps();
        });

        Schema::create('avis_riads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('riad_id')->constrained('riads')->onDelete('cascade');
            $table->integer('note')->nullable();
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['en_attente', 'publie', 'refuse'])->default('en_attente');
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
