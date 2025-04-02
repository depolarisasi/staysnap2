<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Tambahkan kolom total_price jika belum ada
            if (!Schema::hasColumn('carts', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Hapus kolom total_price jika ada
            if (Schema::hasColumn('carts', 'total_price')) {
                $table->dropColumn('total_price');
            }
        });
    }
};
