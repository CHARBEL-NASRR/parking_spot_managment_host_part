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
        Schema::create('parking_spots', function (Blueprint $table) {
            $table->id('spot_id');  // Custom primary key
            $table->unsignedBigInteger('host_id')->nullable();  // Foreign key to Users table
            $table->decimal('longitude', 10, 6)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('price_per_hour', 8, 2)->nullable();
            $table->string('car_type')->nullable();
            $table->string('title')->nullable();
            $table->text('main_description')->nullable();
            $table->float('overall_rating')->nullable();
            $table->string('status')->nullable();

            $table->foreign('host_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps(); // Add timestamps if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_spots');
    }
};