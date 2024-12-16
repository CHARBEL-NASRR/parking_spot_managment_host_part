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
        Schema::create('host_details', function (Blueprint $table) {
            $table->id('host_id'); // Custom primary key
            $table->unsignedBigInteger('user_id'); // Remove nullable to match SQL
            $table->string('id_card', 255)->nullable(); // Default NULL
            
            // Foreign key
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('host_details');
    }
};
