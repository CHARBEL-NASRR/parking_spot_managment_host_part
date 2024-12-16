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
            $table->id('spot_id'); // Primary key
            $table->unsignedBigInteger('host_id'); // Foreign key
            $table->decimal('longitude', 13, 10)->nullable(); 
            $table->decimal('latitude', 13, 10)->nullable();  
            $table->decimal('price_per_hour', 8, 2)->nullable(); 
            $table->enum('car_type', ['2wheeler', '4wheeler', '6wheeler', '8wheeler'])->default('4wheeler');
            $table->string('title', 50)->nullable();
            $table->string('main_description', 50)->nullable();
            $table->decimal('overall_rating', 2, 1)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('verification_documents')->nullable();
            $table->char('key_box', 4)->nullable();
        
            $table->foreign('host_id')->references('host_id')->on('host_details')->onDelete('cascade');
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