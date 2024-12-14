<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('guest_id'); // Foreign key, not nullable
            $table->unsignedBigInteger('spot_id'); // Foreign key, not nullable
            $table->dateTime('start_time'); // Use dateTime for DATETIME columns
            $table->dateTime('end_time'); // Use dateTime for DATETIME columns
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])->default('pending');
            $table->decimal('total_price', 10, 2); // Decimal for price
            $table->timestamps(); // Automatically adds created_at and updated_at

            // Foreign key constraints
            //$table->foreign('guest_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->index('guest_id');
            $table->foreign('spot_id')->references('spot_id')->on('parking_spots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}