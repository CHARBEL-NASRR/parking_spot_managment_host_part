<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->unsignedBigInteger('user_id');  // Not nullable, foreign key
            $table->unsignedBigInteger('admin_id');  // Not nullable, foreign key
            $table->string('type');
            $table->string('title');
            $table->enum('status', ['pending', 'done','seen'])->default('pending');
            $table->string('description', 150);
            $table->string('response', 150);
            $table->timestamps(0);  // Automatically creates `created_at` and `updated_at`

            // Foreign key constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            //$table->foreign('admin_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->index('admin_id');

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}