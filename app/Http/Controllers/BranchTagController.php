<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\BranchTag; 
use Yajra\DataTables\Facades\DataTables;
use App\Traits\HandlesImageUploads;  


class BranchTagController extends Controller
{
    public function index()
    {
        return view('branch-tag.index');
    }

    public function create()
    {
        return view('branch-tag.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);
 
            
            BranchTag::create([
                'name' => $validated['name'] 
            ]);

            alert()->success('Success','Added Successfully'); 
            return redirect()->route('tags.index');

        } catch (\Exception $e) { 
            alert()->error('Error', $e->getMessage()); 
            return redirect()->route('tags.index');
        }


         
    }

    public function edit(BranchTag $tag)
    {
        return view('branch-tag.edit', [
            'tag' => $tag]);
    }

    public function update(Request $request, BranchTag $tag)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $updateData = ['name' => $validated['name']];
 

            $tag->update($updateData);

            alert()->success('Success','Updated Successfully'); 
            return redirect()->route('tags.index');

        } catch (\Exception $e) { 
            alert()->error('Error', $e->getMessage()); 
            return redirect()->route('tags.index');
        }
         
    }

    public function destroy(BranchTag $tag)
    { 

        try { 
            $tag->delete();
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
  
        alert()->success('Success','Deleted Successfully');
        return redirect('management/config/branch/tags');
    }

    public function datatable()
    {
        $tags = BranchTag::query();

        return DataTables::eloquent($tags)
        
            ->addColumn('actions', function($tag) {
                return view('branch-tag.partials.actions', compact('tag'))->render();
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function searchTags(Request $request)
    {
        $request->validate(['search' => 'required|string|min:1']);
        
        $tags = BranchTag::where('name', 'like', "%{$request->search}%")
            ->limit(10)
            ->get()
            ->map(function($tag) {
                return [
                    'id' => $tag->id, // Gunakan ID database
                    'text' => $tag->name
                ];
            });
    
        return response()->json([
            'results' => $tags
        ]);
    }
}
