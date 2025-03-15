<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomPrices;
use Carbon\CarbonPeriod; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomPriceController extends Controller
{

    public function index(Room $room)
    {
        return view('prices.index', compact('room'));
    }

    public function bulkUpdate(Request $request, Room $room)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:'.$room->base_price
        ]);

        $period = CarbonPeriod::create(
            $request->start_date,
            $request->end_date
        );

        DB::transaction(function() use ($period, $room, $request) {
            foreach ($period as $date) {
                RoomPrices::updateOrCreate(
                    [
                        'room_id' => $room->id,
                        'date' => $date->format('Y-m-d')
                    ],
                    [
                        'price' => $request->price
                    ]
                );
            }
        });

        return response()->json(['success' => true]);
    }

    public function getCalendarEvents(Room $room)
    {
        $events = RoomPrices::where('room_id', $room->id)
            ->get()
            ->map(function($price) use ($room) {
                return [
                    'id' => $price->id, // Tambahkan ID untuk operasi delete
                    'room_id' => $room->id, 
                    'title' => 'Rp '.number_format($price->price),
                    'start' => $price->date->format('Y-m-d'),
                    'color' => $price->price > $room->base_price ? '#f56565' : '#48bb78',
                    'extendedProps' => [
                        'type' => 'custom_price',
                    'base_price' => $room->base_price
                    ]
                ];
            });

        return response()->json($events);
    }
     

    public function destroy(Request $request)
    {
        $price = RoomPrices::find($request->priceId);
        try {
            $price->delete();
            return response()->json([
                'success' => true,
                'message' => 'Harga berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus harga: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Room $room, Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Cek data sebelum delete
        $prices = $room->prices()
        ->where('date', '<=', $request->end_date)
        ->where('date', '>=', $request->start_date)
        ->get();

        if ($prices->isEmpty()) {
            return response()->json(['message' => 'Tidak ada harga di range ini'], 404);
        }

        $room->prices()
            ->where('date', '<=', $request->end_date)
            ->where('date', '>=', $request->start_date)
            ->delete();

        return response()->json(['message' => 'Harga berhasil dihapus']);
    }

    public function updateSingle(Room $room, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'price' => 'required|numeric|min:' . $room->base_price
        ]);

        // Hapus harga yang overlap dengan tanggal ini
        $room->prices()
            ->whereDate('date', $request->date) 
            ->delete();
 
            RoomPrices::updateOrCreate(
                [
                    'room_id' => $room->id,
                    'date' => Carbon::parse($request->date)->format('Y-m-d')
                ],
                [
                    'price' => $request->price
                ]
            ); 

        return response()->json(['status' => 'success']);
    }

    public function checkExisting(Room $room, Request $request)
    {
        $exists = $room->prices()
            ->where('date', '<=', $request->end_date)
            ->where('date', '>=', $request->start_date)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function deleteSingle(Room $room, Request $request)
    {
        $request->validate(['date' => 'required|date']);
        
        $room->prices()
            ->where('date', '<=', $request->date)
            ->where('date', '>=', $request->date)
            ->delete();

        return response()->json(['message' => 'Harga berhasil dihapus']);
    }

    public function weekly(Request $request)
    {
        $request->validate(['start_date' => 'required|date']);
        $startDate = Carbon::parse($request->start_date)->toDateString(); // Ubah ke YYYY-MM-DD
        $endDate = Carbon::parse($startDate)->addDays(6)->toDateString(); // YYYY-MM-DD juga
    
        $prices = Room::with(['prices' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }])->get()->map(function($room) use ($startDate) {
            $dates = [];
            for ($i = 0; $i < 7; $i++) {
                
                $currentDate = Carbon::parse($startDate)->copy()->addDays($i);
                $price = RoomPrices::where('room_id',$room->id)
                        ->where('date', $currentDate->format('Y-m-d'))->first();

    
                $dates[] = [
                    'room_id' => $room->id,
                    'room_name' => $room->name,
                    'date' => $currentDate->format('Y-m-d'),
                    'price' => $price? $price->price : $room->base_price
                ];
            }
            return $dates;
        })->flatten(1);  
        return response()->json(['prices' => $prices]);
    }

    public function dynamicPricing()
    {
        $room = Room::first();
        return view('prices.dynamic', compact('room'));
    }

    public function calendar(Request $request)
    {
        $rooms = Room::all();
        
        if($request->has('for_calendar')) {
            return response()->json(
                $rooms->map(function($room) {
                    return [
                        'id' => $room->id,
                        'title' => $room->name,
                        'base_price' => $room->base_price
                    ];
                })
            );
        }
        
        return view('rooms.index', compact('rooms'));
    }

}
