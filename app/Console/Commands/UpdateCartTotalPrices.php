<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Models\Room;
use Carbon\Carbon;

class UpdateCartTotalPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:update-total-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update total_price untuk semua cart yang sudah ada';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai memperbarui total_price pada cart...');
        
        $carts = Cart::all();
        $totalUpdated = 0;
        
        foreach ($carts as $cart) {
            if ($cart->room_id) {
                $room = Room::find($cart->room_id);
                
                if ($room) {
                    // Hitung total hari
                    $checkIn = Carbon::parse($cart->check_in_date);
                    $checkOut = Carbon::parse($cart->check_out_date);
                    $totalDays = $checkIn->diffInDays($checkOut);
                    
                    // Hitung total harga
                    $totalPrice = $room->base_price * $totalDays * $cart->quantity;
                    
                    // Update cart
                    $cart->total_price = $totalPrice;
                    $cart->save();
                    
                    $totalUpdated++;
                }
            }
        }
        
        $this->info("Berhasil memperbarui total_price untuk {$totalUpdated} cart.");
        return Command::SUCCESS;
    }
} 