<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomPrices;
use Carbon\CarbonPeriod; 
use Illuminate\Support\Facades\DB;

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
                    'title' => 'IDR '.number_format($price->price),
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
        ->where('start_date', '<=', $request->end_date)
        ->where('end_date', '>=', $request->start_date)
        ->get();

        if ($prices->isEmpty()) {
            return response()->json(['message' => 'Tidak ada harga di range ini'], 404);
        }

        $room->prices()
            ->where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->delete();

        return response()->json(['message' => 'Harga berhasil dihapus']);
    }
}
