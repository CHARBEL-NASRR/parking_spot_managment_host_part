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
        Schema::create('availability', function (Blueprint $table) {
            $table->id('availability_id'); // Auto-increment primary key
            $table->unsignedBigInteger('spot_id'); // Foreign key, nullable removed (not needed as foreign key is mandatory)
            $table->time('start_time')->nullable(); // Time type for start time
            $table->time('end_time')->nullable(); // Time type for end time
            $table->tinyInteger('day')->unsigned(); // TINYINT for day, unsigned for positive integers

            // Foreign key constraint linking to Parking_Spots
            $table->foreign('spot_id')->references('spot_id')->on('parking_spots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availability');
    }
};