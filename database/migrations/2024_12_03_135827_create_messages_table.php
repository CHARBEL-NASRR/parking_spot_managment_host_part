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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender',false,true);
            $table->bigInteger('receiver',false,true);
            $table->text('message');
            $table->timestamps();
            $table->foreign('sender')->references('host_id')->on('host_details');
            $table->foreign('receiver')->references('host_id')->on('host_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
