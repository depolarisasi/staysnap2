<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSlider;
use App\Models\Branch;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index(){
        $branches = Branch::all()->map(function($branch) {
            $lowestPrice = Room::where('branch_id', $branch->id)
                ->get()
                ->min(function($room) {
                    $dynamicPrice = $room->prices()->min('price');
                    return min($room->base_price, $dynamicPrice ?? $room->base_price);
                });
            
            $branch->lowest_price = $lowestPrice ?? 0;
            return $branch;
        });
    
        $branches = $branches->map(function($branch) {
            $branch->lowest_price = $branch->lowest_price ?? 0;
            return $branch;
        });

        $slider = HomeSlider::get();
        return view('frontpage.index')->with(compact('branches','slider'));
    }

    public function dashboard(){
        return view('index');
    }
}
