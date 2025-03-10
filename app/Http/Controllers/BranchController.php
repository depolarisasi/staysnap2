<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Database\QueryException as QE;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesImageUploads;

class BranchController extends Controller
{
    
    use HandlesImageUploads; 

    protected $imageDirectory = 'branch_logos';
    protected $imageWidth = 5000;
    protected $imageHeight = 5000;
    protected $imageQuality = 80;
    protected $imageFieldName = 'branch_logo';
     
    public function index(){
        $branch = Branch::get();
        return view('branch.index', compact('branch')); 
    }

    public function edit($id){
        $branch = Branch::find($id); 
        return view('branch.edit', compact('branch'));
    }

    public function detail($id){
        $branch = Branch::find($id); 
        return view('branch.detail', compact('branch'));
    }

    public function store(Request $request){
         
        try {
            $validated = $this->validateBranch($request);
            
            if ($request->hasFile($this->imageFieldName)) {
                $validated[$this->imageFieldName] = $this->processAndStoreImage(
                    $request->file($this->imageFieldName)
                );
            }

            Branch::create($validated);

            return redirect('management/config/branches')
                ->with('success', 'Branch created!');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      
    }

    public function update(Request $request){
        
        $branch = Branch::find($request->branch_id);
        try {
            $validated = $this->validateBranch($request, $branch->id);

            if ($request->hasFile($this->imageFieldName)) {
                $this->deleteOldImage($branch->{$this->imageFieldName});
                $validated[$this->imageFieldName] = $this->processAndStoreImage(
                    $request->file($this->imageFieldName)
                );
            }

            $branch->update($validated);

            return redirect('management/config/branches')
                ->with('success', 'Branch updated!');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id){
        $branch = Branch::find($id);
        
        try {
            $this->deleteOldImage($branch->{$this->imageFieldName});
            $branch->delete();

            return redirect('management/config/branches')
                ->with('success', 'Branch deleted!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    private function validateBranch(Request $request, $id = null)
    {
        $rules = [
            'branch_name' => 'required|min:3|max:100',
            'branch_address' => 'required|min:10|max:255',
            'branch_phone' => 'nullable|regex:/^\+?[0-9\s\-]{7,15}$/',
            'branch_web' => 'nullable|url|max:100',
            $this->imageFieldName => $this->imageValidationRules()
        ];

        if ($id) {
            $rules['branch_name'] .= ',branch_name,'.$id;
        }

        return $request->validate($rules);
    }

    private function imageValidationRules()
    {
        return 'nullable|image|mimes:jpeg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000';
    }
}
