<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomPhoto;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesImageUploads;

class RoomPhotoController extends Controller
{
    
    use HandlesImageUploads; 
    protected $imageDirectory = 'room-photos';
    protected $imageFieldName = 'photo';
    protected $imageWidth = 1200;
    protected $imageHeight = 800;

    public function store(Request $request, Room $room)
    {
        $request->validate([
            'photo' => $this->imageValidationRules()[$this->imageFieldName]
        ]);

        $path = $this->processAndStoreImage($request->file('photo'));
        $room->photos()->create(['path' => $path]);

        return redirect()->back();
    }

    public function update(Request $request, RoomPhoto $photo)
    {
        $request->validate([
            'photo' => $this->imageValidationRules()[$this->imageFieldName]
        ]);

        $this->deleteOldImage($photo->path);
        $path = $this->processAndStoreImage($request->file('photo'));
        $photo->update(['path' => $path]);

        return redirect()->back();
    }

    public function destroy(RoomPhoto $photo)
    {
        $this->deleteOldImage($photo->path);
        $photo->delete();
        return redirect()->back();
    }
}
