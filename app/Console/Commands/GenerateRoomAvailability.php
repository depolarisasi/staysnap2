<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room; 
use Illuminate\Support\Carbon;

class GenerateRoomAvailability extends Command
{

    protected $signature = 'generate:room-availability';
    protected $description = 'Generate room availability for next year';

     public function handle()
    {
        Room::chunk(100, function ($rooms) {
            foreach ($rooms as $room) {
                $lastDate = $room->availabilities()
                    ->orderByDesc('date')
                    ->value('date');
    
                $startDate = $lastDate 
                    ? Carbon::parse($lastDate)->addDay()
                    : now();
    
                $endDate = now()->addYear();
                
                // Pastikan tidak generate tanggal mundur
                if ($startDate->gt($endDate)) continue;
                
                $room->generateAvailability($startDate, $endDate);
            }
        });
        
        $this->info('Room availability generated successfully!');
    }
}
