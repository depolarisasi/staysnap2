<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomAvailability; 
use Carbon\CarbonPeriod;     
use Illuminate\Support\Facades\DB;

class RoomAvailabilityController extends Controller
{
    public function index(Room $room)
    {
        return view('availability.index', compact('room'));
    }

    public function bulkUpdate(Request $request, Room $room)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'available' => 'required|integer|min:0|max:'.$room->stock
        ]);

        $period = CarbonPeriod::create(
            $request->start_date,
            $request->end_date
        );

        DB::transaction(function() use ($period, $room, $request) {
            foreach ($period as $date) {
                RoomAvailability::updateOrCreate(
                    [
                        'room_id' => $room->id,
                        'date' => $date->format('Y-m-d')
                    ],
                    [
                        'available' => $request->available
                    ]
                );
            }
        });

        return response()->json(['success' => true]);
    }

    public function getCalendarEvents(Room $room)
    {
        $events = RoomAvailability::where('room_id', $room->id)
            ->get()
            ->map(function($availability) use ($room) {
                return [
                    'id' => $availability->id,
                    'title' => $availability->available.'/'.$room->stock,
                    'start' => $availability->date->format('Y-m-d'),
                    'color' => $this->getAvailabilityColor($availability->available, $room->stock),
                    'extendedProps' => [
                        'type' => 'availability'
                    ]
                ];
            });

        return response()->json($events);
    }

    private function getAvailabilityColor($available, $stock)
    {
        $percentage = ($available / $stock) * 100;
        
        if($percentage >= 75) return '#48bb78'; // Hijau
        if($percentage >= 25) return '#ecc94b'; // Kuning
        return '#f56565'; // Merah
    }

    // Method untuk view all rooms
    public function allRooms()
    {
        $rooms = Room::withCount('availabilities')->get();
        return view('availability.all-rooms', compact('rooms'));
    }

    // Method untuk get events all rooms
    public function getAllCalendarEvents()
    {
        $events = RoomAvailability::with('room')
            ->join('rooms', 'rooms.id', '=', 'room_availabilities.room_id')
            ->select('room_availabilities.*', 'rooms.name as room_name', 'rooms.stock as room_stock')
            ->get()
            ->map(function($availability) {
                return [
                    'id' => $availability->id,
                    'title' => $availability->room_name.': '.$availability->available.'/'.$availability->room_stock,
                    'start' => $availability->date->format('Y-m-d'),
                    'color' => $this->getAvailabilityColor($availability->available, $availability->room_stock),
                    'extendedProps' => [
                        'type' => 'availability',
                        'room_id' => $availability->room_id
                    ]
                ];
            });

        return response()->json($events);
    }
}
