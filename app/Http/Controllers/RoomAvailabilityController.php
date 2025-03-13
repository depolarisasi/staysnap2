<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomAvailability; 
use Carbon\CarbonPeriod;

class RoomAvailabilityController extends Controller
{
    public function index(Room $room)
    {
        return view('admin.rooms.availability.index', [
            'room' => $room,
            'availabilities' => $room->availabilities()
                ->orderBy('date')
                ->paginate(30)
        ]);
    }

    public function bulkUpdate(Request $request, Room $room)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'available' => 'required|integer|min:0|max:'.$room->stock
        ]);

        $period = CarbonPeriod::create(
            $validated['start_date'],
            $validated['end_date']
        );

        foreach ($period as $date) {
            RoomAvailability::updateOrCreate(
                ['room_id' => $room->id, 'date' => $date],
                ['available' => $validated['available']]
            );
        }

        return back()->with('success', __("Availability updated"));
    }

    public function destroy(RoomAvailability $availability)
    {
        $availability->delete();
        return back()->with('success', __("Availability deleted"));
    }

    public function apiAvailability(Room $room)
    {
        return response()->json(
            $room->availabilities->map(function($availability) {
                return [
                    'title' => 'Available: '.$availability->available,
                    'start' => $availability->date,
                    'allDay' => true,
                    'available' => $availability->available
                ];
            })
        );
    }
}
