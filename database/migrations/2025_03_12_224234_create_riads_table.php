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
        Schema::create('riads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('email')->nullable();
            $table->string('rib')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('city');
            $table->string('address');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('rooms')->default(0);
            $table->string('owner');
            $table->integer('reviews')->default(0);
            $table->integer('reservations')->default(0);
            $table->json('facilities');
            $table->json('features');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riads');
    }
};
