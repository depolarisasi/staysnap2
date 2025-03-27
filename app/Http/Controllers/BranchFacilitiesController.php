<?php

namespace App\Http\Controllers;

use App\Models\BranchFacilities; 
use Yajra\DataTables\Facades\DataTables;
use App\Traits\HandlesImageUploads; 
use Illuminate\Http\Request;

class BranchFacilitiesController extends Controller
{
    use HandlesImageUploads; 

    protected $imageDirectory = 'facility';
    protected $imageWidth = 500;
    protected $imageHeight = 500;
    protected $imageQuality = 100;
    protected $imageFieldName = 'facility';
    
    public function index()
    {
        return view('branch-facilities.index');
    }

    public function create()
    {
        return view('branch-facilities.create', [
            'imageFieldName' => $this->imageFieldName, 
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateImage($request, [
                'name' => 'required|string|max:255',
                $this->imageFieldName => 'required|image' // Sesuaikan dengan rules trait
            ]);

            $path = $this->processAndStoreImage($request->file($this->imageFieldName));
            
            BranchFacilities::create([
                'name' => $validated['name'],
                'icon' => $path
            ]);

            alert()->success('Success','Added Successfully'); 
            return redirect()->route('facilities.index');

        } catch (\Exception $e) { 
            alert()->error('Error', $e->getMessage()); 
            return redirect()->route('facilities.index');
        }


         
    }

    public function edit(BranchFacilities $facility)
    {
        return view('branch-facilities.edit', [
            'facility' => $facility,
            'imageFieldName' => $this->imageFieldName, 
        ]);
    }

    public function update(Request $request, BranchFacilities $facility)
    {
        try {
            $validated = $this->validateImage($request, [
                'name' => 'required|string|max:255'
            ]);

            $updateData = ['name' => $validated['name']];

            if ($request->hasFile('facility')) {
                $this->deleteOldImage($facility->icon);
                $updateData['icon'] = $this->processAndStoreImage($request->file('facility'));
            }

            $facility->update($updateData);
  
            alert()->success('Success','Updated Successfully'); 
            return redirect()->route('facilities.index');

        } catch (\Exception $e) { 
            alert()->error('Error', $e->getMessage()); 
            return redirect()->route('facilities.index');
        }
         
    }

    public function destroy(BranchFacilities $facility)
    { 

        try { 
            $facility->delete();
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
  
        alert()->success('Success','Deleted Successfully');
        return redirect('management/amenities');
    }

    public function datatable()
    {
        $facilities = BranchFacilities::query();

        return DataTables::eloquent($facilities) 
            ->addColumn('actions', function($facility) {
                return view('branch-facilities.partials.actions', compact('facility'))->render();
            })
            ->rawColumns(['icon_preview', 'actions'])
            ->toJson();
    }
}
