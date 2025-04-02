<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Room;
use App\Models\RoomPrices;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Get all hotels
     */
    public function getHotels()
    {
        $hotels = Branch::with(['regency', 'province'])->get();
        
        return response()->json($hotels);
    }
    
    /**
     * Get room prices for a specific branch/hotel
     */
    public function getRoomPrices(Request $request, $branchId)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        if (!$startDate || !$endDate) {
            $startDate = now()->format('Y-m-d');
            $endDate = now()->addYear()->format('Y-m-d');
        }
        
        // Ambil kamar dari branch/hotel yang dipilih
        $rooms = Room::where('branch_id', $branchId)->get();
        
        if ($rooms->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada kamar yang tersedia untuk hotel ini',
                'prices' => []
            ]);
        }
        
        // Dapatkan ID kamar
        $roomIds = $rooms->pluck('id')->toArray();
        
        // Dapatkan harga kamar untuk tanggal yang dipilih
        $prices = RoomPrices::whereIn('room_id', $roomIds)
                ->whereBetween('date', [$startDate, $endDate])
                ->get()
                ->groupBy(function ($price) {
                    return $price->date->format('Y-m-d');
                })
                ->map(function ($dayPrices) {
                    return [
                        'lowest' => $dayPrices->min('price'),
                        'highest' => $dayPrices->max('price'),
                        'rooms' => $dayPrices->groupBy('room_id')
                            ->map(function ($roomPrices) {
                                return $roomPrices->first()->price;
                            })
                    ];
                });
        
        // Tambahkan harga dasar untuk kamar jika tidak ada harga khusus
        $roomBasePrices = $rooms->mapWithKeys(function ($room) {
            return [$room->id => $room->base_price];
        });
        
        // Harga terendah dari semua kamar
        $lowestBasePrice = $rooms->min('base_price');
        
        return response()->json([
            'status' => 'success',
            'prices' => $prices->toArray(),
            'room_base_price' => $lowestBasePrice,
            'room_prices' => $roomBasePrices
        ]);
    }
} 