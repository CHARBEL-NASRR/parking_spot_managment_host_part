<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('sender_wallet_id')->nullable();
            $table->unsignedBigInteger('receiver_wallet_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->string('transaction_type', 50)->nullable();
            $table->string('deducted_amount', 50)->nullable();
            $table->string('received_amount', 50)->nullable();
            $table->string('commission_amount', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('ticket_id')->nullable();

            $table->foreign('sender_wallet_id')->references('id')->on('wallets');
            $table->foreign('receiver_wallet_id')->references('id')->on('wallets');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}