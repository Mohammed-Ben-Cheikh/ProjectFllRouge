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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->string('tourist_name')->nullable();
            $table->string('tourist_email')->nullable();
            $table->decimal('montant', 8, 2)->nullable();
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->string('reference_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
