<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetParamsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('set_param', function (Blueprint $table) {
            $table->id('condition_id'); // Auto-increment primary key
            $table->decimal('threshold_amount', 10, 2); // DECIMAL for the threshold amount
            $table->string('schedule', 50); // VARCHAR for the schedule
            $table->decimal('commission_rate', 5, 2); // DECIMAL for commission rate with 2 decimal points
            $table->timestamp('created_at')->useCurrent(); // Timestamp with current time
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