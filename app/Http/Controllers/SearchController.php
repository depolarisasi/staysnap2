<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Room;
use App\Models\RoomAvailability;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $hotelId = $request->hotel_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $adults = $request->adults;
        $kids = $request->kids;
        $voucher = $request->voucher;
        
        // Validasi input
        if (!$hotelId || !$startDate || !$endDate) {
            return redirect('/')->with('error', 'Parameter pencarian tidak lengkap.');
        }
        
        // Ambil data hotel
        $hotel = Branch::with(['regency', 'province'])->find($hotelId);
        if (!$hotel) {
            return redirect('/')->with('error', 'Hotel tidak ditemukan.');
        }
        
        // Ambil kamar yang tersedia
        $rooms = Room::where('branch_id', $hotelId)
            ->with(['photos', 'amenities', 'policies', 'availabilities' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($room) use ($startDate, $endDate) {
                // Hitung total harga
                $start = Carbon::parse($startDate);
                $end = Carbon::parse($endDate);
                $nights = $start->diffInDays($end);
                
                // Hitung total harga berdasarkan harga dasar
                $totalPrice = $room->base_price * $nights;
                
                // Cek ketersediaan kamar
                $isAvailable = true;
                $availableRooms = $room->stock;
                
                // Jika ada data availability, gunakan itu
                if ($room->availabilities->isNotEmpty()) {
                    $minAvailable = $room->availabilities->min('available');
                    $availableRooms = $minAvailable;
                    $isAvailable = $minAvailable > 0;
                }
                
                // Tambahkan informasi availability ke room
                $room->availability = (object)[
                    'is_available' => $isAvailable,
                    'available_rooms' => $availableRooms,
                    'total_price' => $totalPrice
                ];
                
                return $room;
            });
            
        // Ambil semua room policy yang unik dari semua kamar
        $allPolicies = new Collection();
        
        foreach ($rooms as $room) {
            foreach ($room->policies as $policy) {
                if (!$allPolicies->contains('id', $policy->id)) {
                    $allPolicies->push($policy);
                }
            }
        }
        
        // Urut policies berdasarkan nama (tidak ada grouping)
        $sortedPolicies = $allPolicies->sortBy('name');
        
        // Kirim data ke view
        return view('frontpage.search-results', [
            'hotel' => $hotel,
            'rooms' => $rooms,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'adults' => $adults,
            'kids' => $kids,
            'voucher' => $voucher,
            'policies' => $sortedPolicies
        ]);
    }
} 