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
            $table->id('availability_id'); 
            $table->unsignedBigInteger('spot_id');
            $table->time('start_time_availability'); 
            $table->time('end_time_availability');    
            $table->integer('day');  
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