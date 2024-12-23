<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateSetParamsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('set_param', function (Blueprint $table) {
            $table->id('condition_id');
            $table->decimal('threshold_amount', 10, 2);
            $table->string('schedule', 50);
            $table->string('commission_rate', 50);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_param');
    }
}