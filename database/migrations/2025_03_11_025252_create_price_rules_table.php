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
        Schema::create('price_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['seasonal', 'last_minute', 'weekend']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('adjustment_type', ['percent', 'nominal']);
            $table->decimal('adjustment_value', 8, 2); // Allows up to 999999.99
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_rules');
    }
};
