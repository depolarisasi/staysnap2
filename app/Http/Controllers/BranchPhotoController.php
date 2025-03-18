<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Branch;
use App\Models\BranchPhoto;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesImageUploads;

class BranchPhotoController extends Controller
{
    protected $imageDirectory = 'branch-photos';
    protected $imageFieldName = 'photo';
    protected $imageWidth = 1200;
    protected $imageHeight = 800;

    public function store(Request $request, Branch $branch)
    {
        $request->validate([
            'photo' => $this->imageValidationRules()[$this->imageFieldName]
        ]);

        $path = $this->processAndStoreImage($request->file('photo'));
        $branch->photos()->create(['path' => $path]);

        return redirect()->back();
    }

    public function update(Request $request, BranchPhoto $photo)
    {
        $request->validate([
            'photo' => $this->imageValidationRules()[$this->imageFieldName]
        ]);

        $this->deleteOldImage($photo->path);
        $path = $this->processAndStoreImage($request->file('photo'));
        $photo->update(['path' => $path]);

        return redirect()->back();
    }

    public function destroy(BranchPhoto $photo)
    {
        $this->deleteOldImage($photo->path);
        $photo->delete();
        return redirect()->back();
    }
}
