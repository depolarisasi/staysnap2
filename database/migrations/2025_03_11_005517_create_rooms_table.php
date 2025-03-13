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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained();
            $table->string('name');
            $table->decimal('base_price', 12, 2);
            $table->text('description');
            $table->integer('capacity'); // Total orang
            $table->string('room_size'); // Contoh: "30 m²"
            $table->text('special_bonus')->nullable();
            $table->integer('stock');
            $table->enum('status', ['operational', 'maintenance', 'closed']);
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
        Schema::dropIfExists('rooms');
    }
};
