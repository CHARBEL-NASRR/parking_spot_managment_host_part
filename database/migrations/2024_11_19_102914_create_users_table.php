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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');  // Custom primary key
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number', 15);  // Correct length
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['pending', 'active', 'blocked'])->default('pending');  // Correct ENUM type
            $table->string('google_id')->nullable();
            $table->string('validate_token')->nullable();
            $table->boolean('is_valid')->default(false);
            $table->timestamp('expired_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
