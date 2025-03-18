<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Branch;
use App\Models\Amenity;
use App\Models\RoomPolicy; 
use App\Models\RoomPhotos; 
use Illuminate\Http\Request;
use App\Traits\HandlesImageUploads; 
use Yajra\DataTables\Facades\DataTables;
use Exception;
use DB;

class RoomController extends Controller
{
    use HandlesImageUploads; 

    protected $imageDirectory = 'room_photos';
    protected $imageWidth = 5000;
    protected $imageHeight = 5000;
    protected $imageQuality = 80;
    protected $imageFieldName = 'photos';

    public function index()
    {
        return view('rooms.index');
    }
    public function create()
    {
        return view('rooms.create', [
            'branches' => Branch::all(),
            'amenities' => Amenity::all(),
            'policies' => RoomPolicy::all(),
            'room' => new Room()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'room_size' => 'nullable|string', 
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:operational,maintenance,closed',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id', // Tambahkan validasi ID
            'policies' => 'nullable|array',
            'policies.*' => 'exists:room_policies,id', // Validasi ID policy
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp'
        ], [
            'photos.*.image' => 'File harus berupa gambar',
            'photos.*.max' => 'Ukuran gambar maksimal 2MB',
            'amenities.*.exists' => 'Amenity tidak valid',
            'policies.*.exists' => 'Policy tidak valid'
        ]);

        try {
            DB::beginTransaction();

            $room = Room::create($validated);

            $room->amenities()->sync($request->amenities ?? []);
            $room->policies()->sync($request->policies ?? []);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $this->processAndStoreImage($photo);
                    $room->photos()->create(['path' => $path]);
                }
            }

            DB::commit();
            
            alert()->success('Success','Added Successfully'); 
            return redirect()->route('rooms.index');

        } catch (Exception $e) {
            DB::rollBack();

            // Debugging detail
            logger()->error('Room creation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);

            alert()->error('Error', $e->getMessage());  
            return redirect()->back()->withInput();
        }
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', [
            'room' => $room->load(['amenities', 'policies']),
            'branches' => Branch::all(),
            'amenities' => Amenity::all(),
            'policies' => RoomPolicy::all()
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'room_size' => 'nullable|string|max:50',
            'special_bonus' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:operational,maintenance,closed',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'policies' => 'nullable|array',
            'policies.*' => 'exists:room_policies,id',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp',
            'deleted_photos' => 'nullable|array',
            'deleted_photos.*' => 'exists:room_photos,id'
        ]);
        try {
            DB::beginTransaction();

            $room->update($validated);

            // Sync relationships
            $room->amenities()->sync($request->amenities ?? []);
            $room->policies()->sync($request->policies ?? []);

            // Handle deleted photos
            if ($request->filled('deleted_photos')) {
                foreach ($request->deleted_photos as $photoId) {
                    $photo = $room->photos()->findOrFail($photoId);
                    $this->deleteOldImage($photo->path);
                    $photo->delete();
                }
            }

            // Add new photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $newPhoto) {
                    $path = $this->processAndStoreImage($newPhoto);
                    $room->photos()->create(['path' => $path]);
                }
            }

            DB::commit();

            alert()->success('Success','Updated Successfully'); 
            return redirect()->route('rooms.index');

        } catch (Exception $e) {
            DB::rollBack();

            logger()->error('Room update error: ' . $e->getMessage(), [
                'room_id' => $room->id,
                'input' => $request->except('photos')
            ]);

            alert()->error('Error', $e->getMessage());  
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Room $room)
    {
        try {
            DB::beginTransaction();

            // Delete photos
            foreach ($room->photos as $photo) {
                $this->deleteOldImage($photo->path);
                $photo->delete();
            }

            // Delete relationships
            $room->amenities()->detach();
            $room->policies()->detach();

            $room->delete();

            DB::commit();

            alert()->success('Success','Deleted Successfully'); 
            return redirect()->route('rooms.index');

        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Error', $e->getMessage());  
            return redirect()->back();
        }
    }

    public function datatable(Request $request)
    {
        abort_unless($request->ajax(), 404); // Pastikan hanya menerima request AJAX

        $rooms = Room::with('branch')
        ->select('rooms.*')
        ->when($request->has('search.value'), function($query) use ($request) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('rooms.branch_name', 'like', "%$search%")
                  ->orWhereHas('branch', function($q) use ($search) {
                      $q->where('branch_name', 'like', "%$search%");
                  });
            });
        });


        return DataTables::eloquent($rooms)
            ->addColumn('status', function($room) {
                return $room->status; // Pastikan mengembalikan nilai string
            })  
            ->addColumn('actions', function($room) {
                return view('rooms.partials.actions', [
                    'id' => $room->id,
                    'editRoute' => route('rooms.edit', $room->id),
                    'pricingRoute' => route('prices.index', $room->id),
                    'availabilityRoute' => route('availability.index', $room->id),
                    'deleteRoute' => route('rooms.destroy', $room->id)
                ])->render();
            })
            ->editColumn('base_price', function($room) {
                return (float)$room->base_price; // Konversi ke float
            })
            ->orderColumn('branch.name', function($query, $order) {
                $query->join('branches', 'branches.id', '=', 'rooms.branch_id')
                      ->orderBy('branches.name', $order);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
