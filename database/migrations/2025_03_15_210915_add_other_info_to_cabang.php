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
            // Cek dan tambahkan kolom jika belum ada
            if (!Schema::hasColumn('branches', 'branch_star')) {
                $table->integer('branch_star')->nullable();
            }
            
            if (!Schema::hasColumn('branches', 'branch_maps_link')) {
                $table->string('branch_maps_link')->nullable();
            }
            
            if (!Schema::hasColumn('branches', 'branch_city')) {
                $table->string('branch_city')->nullable();
            }
            
            if (!Schema::hasColumn('branches', 'branch_thumbnail')) {
                $table->string('branch_thumbnail')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('branches', function (Blueprint $table) {
        //     $table->dropColumn(['branch_province','branch_star','branch_maps_link','branch_city','branch_thumbnail']); 
        // });
    }
};
