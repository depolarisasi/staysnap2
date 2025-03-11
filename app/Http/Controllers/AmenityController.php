<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity; 
use Yajra\DataTables\Facades\DataTables;
use App\Traits\HandlesImageUploads; 

class AmenityController extends Controller
{
    use HandlesImageUploads; 

    protected $imageDirectory = 'amenities';
    protected $imageWidth = 500;
    protected $imageHeight = 500;
    protected $imageQuality = 100;
    protected $imageFieldName = 'image';
    
    public function index()
    {
        return view('amenities.index');
    }

    public function create()
    {
        return view('amenities.create', [
            'imageFieldName' => $this->imageFieldName, 
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateImage($request, [
                'name' => 'required|string|max:255|unique:amenities',
                $this->imageFieldName => 'required|image' // Sesuaikan dengan rules trait
            ]);

            $path = $this->processAndStoreImage($request->file($this->imageFieldName));
            
            Amenity::create([
                'name' => $validated['name'],
                'icon' => $path
            ]);

            alert()->success('Success','Added Successfully'); 
            return redirect()->route('amenities.index');

        } catch (\Exception $e) { 
            alert()->error('Error', $e->getMessage()); 
            return redirect()->route('amenities.index');
        }


         
    }

    public function edit(Amenity $amenity)
    {
        return view('amenities.edit', [
            'amenity' => $amenity,
            'imageFieldName' => $this->imageFieldName, 
        ]);
    }

    public function update(Request $request, Amenity $amenity)
    {
        try {
            $validated = $this->validateImage($request, [
                'name' => 'required|string|max:255|unique:amenities,name,'.$amenity->id
            ]);

            $updateData = ['name' => $validated['name']];

            if ($request->hasFile($this->imageFieldName)) {
                $this->deleteOldImage($amenity->icon);
                $updateData['icon'] = $this->processAndStoreImage(
                    $request->file($this->imageFieldName)
                );
            }

            $amenity->update($updateData);

            alert()->success('Success','Updated Successfully'); 
            return redirect()->route('amenities.index');

        } catch (\Exception $e) { 
            alert()->error('Error', $e->getMessage()); 
            return redirect()->route('amenities.index');
        }
         
    }

    public function destroy(Amenity $amenity)
    { 

        try { 
            $amenity->delete();
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
  
        alert()->success('Success','Deleted Successfully');
        return redirect('management/amenities');
    }

    public function datatable()
    {
        $amenities = Amenity::query();

        return DataTables::eloquent($amenities)
            ->addColumn('icon_preview', function($amenity) {
                if ($amenity->icon) {
                    return '<div class="d-flex align-items-center gap-2">
                                <i class="'.$amenity->icon.' fs-4 text-primary"></i>
                                <code>'.$amenity->icon.'</code>
                            </div>';
                }
                return '-';
            })
            ->addColumn('actions', function($amenity) {
                return view('amenities.partials.actions', compact('amenity'))->render();
            })
            ->rawColumns(['icon_preview', 'actions'])
            ->toJson();
    }
}
