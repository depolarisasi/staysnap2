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
        Schema::create('room_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "refundable"
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Pivot table
        Schema::create('policy_room', function (Blueprint $table) {
            $table->foreignId('room_id')->constrained();
            $table->foreignId('room_policy_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_policies');
        Schema::dropIfExists('policy_room');
    }
};
