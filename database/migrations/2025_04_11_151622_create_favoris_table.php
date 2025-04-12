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
        Schema::create('favoris_riads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('favoris_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('favoris_chambres', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('favoris_villes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
