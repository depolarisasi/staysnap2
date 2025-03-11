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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "AC", "TV"
            $table->string('icon')->nullable(); // Bonus: untuk UI
            $table->timestamps();
        });
        
        // Pivot table
        Schema::create('amenity_room', function (Blueprint $table) {
            $table->foreignId('room_id')->constrained();
            $table->foreignId('amenity_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amenities');
        Schema::dropIfExists('amenity_room');
    }
};
