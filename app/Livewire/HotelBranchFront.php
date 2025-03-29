<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Branch;
use App\Models\Room;

class HotelBranchFront extends Component
{
    public $branches = [];
    
    public function mount() {
        $this->branches = Branch::all()->map(function($branch) {
            $lowestPrice = Room::where('branch_id', $branch->id)
                ->get()
                ->min(function($room) {
                    $dynamicPrice = $room->prices()->min('price');
                    return min($room->base_price, $dynamicPrice ?? $room->base_price);
                });
            
            $branch->lowest_price = $lowestPrice ?? 0;
            return $branch;
        });
    
        $this->branches = $this->branches->map(function($branch) {
            $branch->lowest_price = $branch->lowest_price ?? 0;
            return $branch;
        });

    }
    public function render()
    {
        
        return view('livewire.hotel-branch-front');
    }
}
