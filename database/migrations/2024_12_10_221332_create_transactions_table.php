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
            $table->id('transaction_id'); // Auto-increment primary key
            $table->unsignedBigInteger('sender_wallet_id'); // Foreign key for sender_wallet_id
            $table->unsignedBigInteger('receiver_wallet_id'); // Foreign key for receiver_wallet_id
            $table->unsignedBigInteger('booking_id'); // Foreign key for booking_id
            $table->enum('transaction_type', ['pending', 'transferred', 'refunded', 'rejected'])->default('pending'); // Enum for transaction type with default value
            $table->decimal('deducted_amount', 10, 2)->nullable(); // DECIMAL for deducted_amount
            $table->decimal('received_amount', 10, 2)->nullable(); // DECIMAL for received_amount
            $table->decimal('commission_amount', 10, 2)->nullable(); // DECIMAL for commission_amount
            $table->timestamp('created_at')->useCurrent(); // Timestamp for when the transaction is created
            $table->unsignedBigInteger('ticket_id')->nullable(); // Foreign key for ticket_id (nullable)

            // Define foreign key constraints to other tables
            $table->foreign('sender_wallet_id')->references('wallet_id')->on('wallets')->onDelete('cascade');
            $table->foreign('receiver_wallet_id')->references('wallet_id')->on('wallets')->onDelete('cascade');
            $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onDelete('set null');
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