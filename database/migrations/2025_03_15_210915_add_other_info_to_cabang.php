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
        Schema::table('branches', function (Blueprint $table) { 
            $table->integer('branch_star')->nullable();   
            $table->string('branch_maps_link')->nullable();   
            $table->string('branch_city')->nullable();   
            $table->string('branch_thumbnail')->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            //
        });
    }
};
