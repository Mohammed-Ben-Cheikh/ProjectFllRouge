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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('owner');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->text('description');
            $table->string('logo')->nullable();
            $table->json('documents');
            $table->integer('riadsCount')->default(0);
            $table->integer('employeesCount')->default(0);
            $table->boolean('destroy')->default(false);
            $table->timestamps(); // Création des colonnes `created_at` et `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
