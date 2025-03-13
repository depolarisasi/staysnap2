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
        Schema::create('vouchers', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();
        $table->enum('type', ['percentage', 'fixed']);
        $table->decimal('value', 10, 2);
        $table->date('valid_from');
        $table->date('valid_to');
        $table->integer('usage_limit')->default(1);
        $table->integer('used_count')->default(0);
        $table->timestamps();
    });
    
    // Pivot table untuk voucher berlaku ke kamar tertentu
    Schema::create('room_voucher', function (Blueprint $table) {
        $table->foreignId('room_id')->constrained();
        $table->foreignId('voucher_id')->constrained();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
