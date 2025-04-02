<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Regency;
use App\Models\Room;
use App\Models\RoomPrices;
use Carbon\Carbon;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        $regencies = Regency::whereIn('id', Branch::distinct()->pluck('branch_city'))->get();
        
        // Transform regency data untuk memastikan properti name tersedia
        $regencies = $regencies->map(function($regency) {
            return [
                'id' => $regency->id,
                'name' => $regency->regency, // Gunakan field 'regency' sebagai 'name'
                'province_id' => $regency->province_id
            ];
        });
        
        return response()->json([
            'branches' => $branches,
            'regencies' => $regencies
        ]);
    }
    
    /**
     * Mendapatkan harga kamar untuk tanggal tertentu berdasarkan branch_id
     * 
     * @param Request $request
     * @param int $branchId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoomPrices(Request $request, $branchId)
    {
        try {
            // Validasi input
            $request->validate([
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);
            
            // Ambil tanggal mulai dan akhir dari request, atau default ke rentang 30 hari
            $startDate = $request->input('start_date', Carbon::now()->format('Y-m-d'));
            $endDate = $request->input('end_date', Carbon::parse($startDate)->addDays(30)->format('Y-m-d'));
            
            // Dapatkan semua kamar untuk branch tersebut
            $rooms = Room::where('branch_id', $branchId)->get();
            
            if ($rooms->isEmpty()) {
                \Log::warning("No rooms found for branch ID: {$branchId}");
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada kamar yang tersedia untuk hotel ini',
                    'prices' => [],
                    'room_base_price' => null
                ]);
            }
            
            // Hitung harga dasar terendah dari semua kamar
            $roomBasePrice = $rooms->min('base_price');
            
            // Inisialisasi array untuk menyimpan harga
            $prices = [];
            
            // Bentuk rentang tanggal
            $period = Carbon::parse($startDate)->daysUntil($endDate);
            
            // Untuk setiap tanggal dalam rentang
            foreach ($period as $date) {
                $formattedDate = $date->format('Y-m-d');
                $prices[$formattedDate] = [];
                
                // Untuk setiap kamar, dapatkan harga pada tanggal tersebut
                foreach ($rooms as $room) {
                    // Cari harga kustom untuk tanggal ini
                    $customPrice = RoomPrices::where('room_id', $room->id)
                        ->where('date', $formattedDate)
                        ->first();
                    
                    // Jika ada harga kustom, gunakan itu. Jika tidak, gunakan harga dasar
                    $price = $customPrice ? $customPrice->price : $room->base_price;
                    
                    // Simpan harga terendah untuk tanggal ini
                    if (!isset($prices[$formattedDate]['lowest']) || $price < $prices[$formattedDate]['lowest']) {
                        $prices[$formattedDate]['lowest'] = $price;
                    }
                    
                    // Simpan harga per kamar
                    $prices[$formattedDate]['rooms'][$room->id] = $price;
                }
            }
            
            \Log::info("Successfully fetched prices for branch ID: {$branchId}", [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'room_count' => $rooms->count(),
                'price_dates' => count($prices),
                'base_price' => $roomBasePrice
            ]);
            
            return response()->json([
                'status' => 'success',
                'prices' => $prices,
                'room_base_price' => $roomBasePrice
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error fetching room prices for branch ID: {$branchId}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data harga',
                'prices' => [],
                'room_base_price' => null
            ], 500);
        }
    }
} 