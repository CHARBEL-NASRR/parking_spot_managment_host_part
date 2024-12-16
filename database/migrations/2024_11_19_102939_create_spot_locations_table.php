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
        Schema::create('spot_locations', function (Blueprint $table) {
            $table->id('location_id');  // Custom primary key
            $table->unsignedBigInteger('spot_id')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
        
            // Foreign key constraint linking to Parking_Spots
            $table->foreign('spot_id')->references('spot_id')->on('parking_spots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_locations');
    }
};
