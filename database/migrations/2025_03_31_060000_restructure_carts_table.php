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
        Schema::table('carts', function (Blueprint $table) {
            // Tambahkan kolom-kolom yang dibutuhkan jika belum ada
            if (!Schema::hasColumn('carts', 'room_id')) {
                $table->foreignId('room_id')->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('carts', 'check_in_date')) {
                $table->date('check_in_date')->nullable()->after('room_id');
            }
            
            if (!Schema::hasColumn('carts', 'check_out_date')) {
                $table->date('check_out_date')->nullable()->after('check_in_date');
            }
            
            if (!Schema::hasColumn('carts', 'adult_count')) {
                $table->integer('adult_count')->default(1)->after('check_out_date');
            }
            
            if (!Schema::hasColumn('carts', 'kids_count')) {
                $table->integer('kids_count')->default(0)->after('adult_count');
            }
            
            if (!Schema::hasColumn('carts', 'quantity')) {
                $table->integer('quantity')->default(1)->after('kids_count');
            }
            
            if (!Schema::hasColumn('carts', 'price')) {
                $table->decimal('price', 10, 2)->default(0)->after('quantity');
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
        Schema::table('carts', function (Blueprint $table) {
            // Hapus kolom-kolom yang ditambahkan
            $columns = [
                'room_id',
                'check_in_date',
                'check_out_date',
                'adult_count',
                'kids_count',
                'quantity',
                'price'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('carts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 