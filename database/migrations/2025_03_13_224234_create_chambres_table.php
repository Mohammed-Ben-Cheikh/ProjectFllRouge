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
        Schema::create('chambres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->string('city');
            $table->enum('type', ['standard', 'deluxe', 'suite']);
            $table->string('description')->nullable();
            $table->json('equipements')->nullable();
            $table->integer('prix')->nullable();
            $table->integer('nombre_lits')->nullable();
            $table->json('capacity')->nullable();
            $table->decimal('surface',8,2)->nullable();
            $table->integer('rating')->nullable();
            $table->enum('statut', ['available', 'unavailable', 'booked'])->default('available'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};
