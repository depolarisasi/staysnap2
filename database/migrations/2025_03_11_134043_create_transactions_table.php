<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Tamu yang booking
            $table->foreignId('room_id')->constrained();
            $table->string('tripay_reference')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('payment_fee', 12, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'failed', 'expired']);
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('adults');
            $table->integer('children')->default(0);
            $table->text('special_request')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
