<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mengubah kolom selected_rooms menjadi nullable
        Schema::table('carts', function (Blueprint $table) {
            $table->json('selected_rooms')->nullable()->change();
        });
        
        // Update cart yang sudah ada dengan nilai default untuk selected_rooms
        try {
            $carts = DB::table('carts')
                ->whereNull('selected_rooms')
                ->orWhere('selected_rooms', '')
                ->get();
                
            foreach ($carts as $cart) {
                $selectedRooms = [];
                
                if ($cart->room_id) {
                    $selectedRooms[$cart->room_id] = [
                        'check_in' => $cart->check_in_date,
                        'check_out' => $cart->check_out_date,
                        'adult_count' => $cart->adult_count,
                        'kids_count' => $cart->kids_count,
                        'quantity' => $cart->quantity,
                        'price' => $cart->price
                    ];
                    
                    DB::table('carts')
                        ->where('id', $cart->id)
                        ->update(['selected_rooms' => json_encode($selectedRooms)]);
                }
            }
        } catch (\Exception $e) {
            // Jika terjadi error, lanjutkan proses migrasi
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kolom tidak dapat diubah kembali menjadi NOT NULL karena mungkin 
        // sudah ada data yang memiliki nilai NULL
    }
}; 