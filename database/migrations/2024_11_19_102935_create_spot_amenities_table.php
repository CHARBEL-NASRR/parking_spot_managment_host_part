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
        Schema::create('spot_amenities', function (Blueprint $table) {
            $table->id('amenity_id');  // Custom primary key
            $table->unsignedBigInteger('spot_id');  // Foreign key to Parking_Spots
            $table->tinyInteger('is_covered')->default(0);  // Default value of 0 (false)
            $table->tinyInteger('is_gated')->default(0);  // Default value of 0 (false)
            $table->tinyInteger('has_security')->default(0);  // Default value of 0 (false)
            $table->tinyInteger('has_ev_charging')->default(0);  // Default value of 0 (false)
            $table->tinyInteger('is_handicap_accessible')->default(0);  // Default value of 0 (false)
            $table->tinyInteger('has_lighting')->default(0);  // Default value of 0 (false)
            $table->tinyInteger('has_cctv')->default(0);  // Default value of 0 (false)
        
            // Foreign key constraint linking to Parking_Spots
            $table->foreign('spot_id')->references('spot_id')->on('parking_spots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spot_amenities');
    }
};
