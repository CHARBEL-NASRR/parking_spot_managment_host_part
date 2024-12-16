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
        Schema::create('images', function (Blueprint $table) {
            $table->id('image_id'); // Auto-increment primary key
            $table->unsignedBigInteger('spot_id'); // Foreign key, no longer nullable
            $table->string('image_url', 255)->nullable(); // image_url with a length of 255
        
            // Foreign key constraint linking to Parking_Spots
            $table->foreign('spot_id')->references('spot_id')->on('parking_spots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
