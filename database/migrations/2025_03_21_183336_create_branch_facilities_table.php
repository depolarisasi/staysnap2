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
        Schema::create('branch_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "AC", "TV"
            $table->string('icon')->nullable(); // Bonus: untuk UI
            $table->timestamps();
        });
        
        // Pivot table  
        Schema::create('facilities_branch', function (Blueprint $table) {
            $table->foreignId('branch_id')->constrained('branches'); // Ganti 'branches' dengan nama tabel branch Anda
            $table->foreignId('facilities_id')->constrained('branch_facilities'); // 👈 refer ke tabel yang benar
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_facilities');
        Schema::dropIfExists('facilities_branch');
    }
};
