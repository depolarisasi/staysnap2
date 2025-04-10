<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\BranchPhotos; 
use App\Models\BranchTag; 
use App\Models\BranchFacilities;
use Illuminate\Database\QueryException as QE;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesImageUploads; 
use Exception;
use DB;
class BranchController extends Controller
{
    
    use HandlesImageUploads; 

    protected $imageDirectory = 'branch_logos';
    protected $imageWidth = 10000;
    protected $imageHeight = 10000;
    protected $imageQuality = 80;
    protected $imageFieldName = 'branch_logo';
     
    public function index(){
        $branch = Branch::with('province')->with('regency')->get();
        return view('branch.index', compact('branch')); 
    }

    public function create(){ 
        
    // Kirim branch kosong untuk form create
    $branch = new Branch();
    
    // Ambil semua tags existing (opsional)
    $existingTags = BranchTag::all()->pluck('name');
        $facilities = BranchFacilities::all();
        return view('branch.create')->with(compact('facilities','existingTags','branch'));
    }

    public function edit($id){
        $branch = Branch::with([
            'facilities',
            'province',
            'regency',
            'photos',
            'tags' => function($query) {
                $query->withTimestamps(); // Pastikan mengambil timestamp
            }
        ])->findOrFail($id);
    
        $facilities = BranchFacilities::all();
        return view('branch.edit', compact('branch','facilities'));
    }

    public function show($branch){
        $branch = Branch::with('facilities')->with('province')->with('regency')->with('tags')->with('photos')->findOrFail($branch); 
        return view('branch.show')->with(compact('branch'));
    }
    
    public function detail($id){
        $branch = Branch::with('facilities')->with('province')->with('regency')->with('photos')->find($id); 
        return view('branch.detail', compact('branch'));
    }

    public function store(Request $request){
       
        $validated = $request->validate([
            'branch_name' => 'required|min:3|max:100',
            'branch_address' => 'required|min:3|max:255',
            'branch_province' => 'required',
            'branch_city' => 'required',
            'branch_star' => 'required',
            'branch_maps_link' => 'required',
            'branch_description' => 'nullable|max:1000',
            'tags' => 'sometimes|array',
            'tags.*' => [
                'required',
                'string',
                'max:255',
                'exists:branch_tags,id' // Pastikan tag sudah ada di database
            ],
            'branch_logo' => 'nullable|image|mimes:jpeg,png,webp', 
            'branch_photos' => 'nullable|array',
            'branch_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp' 
        ],['branch_photos.*.image' => 'File harus berupa gambar',
        'branch_photos.*.max' => 'Ukuran gambar maksimal 2MB',  ]);
 
        try { 
            
            DB::beginTransaction();
            
     $branch = Branch::create(Arr::except($validated, ['tags']));

          
            $branch->tags()->sync($validated['tags']); 
            $branch->facilities()->sync($request->facilities ?? []);
            
            if ($request->hasFile('branch_logo')) {  
                $branch->branch_logo = $this->processAndStoreImage($request->file('branch_logo'), 'branch_logos', 'branch_logo');
                $branch->save();
            }

            if ($request->hasFile('branch_thumbnail')) {  
                $branch->branch_thumbnail = $this->processAndStoreImage($request->file('branch_thumbnail'), 'branch_thumbnails', 'branch_thumbnail');
                $branch->save();
            }


            if ($request->hasFile('branch_photos')) {
                foreach ($request->file('branch_photos') as $photo) {
                    $path = $this->processAndStoreImage($photo, 'branch_photos', 'branch_photos');
                    $branch->photos()->create([
                        'branch_id' => $branch->id, // Pastikan ID branch ditambahkan
                        'path' => $path
                    ]);
                    
                }
            }

           
            DB::commit();

            alert()->success('Success', 'Branch Berhasil Dibuat');
            return redirect('management/config/branch');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
      
    }

    public function update(Request $request, Branch $branch)
    {
         
        $validated = $request->validate([
            'branch_name' => 'required|min:3|max:100',
            'branch_address' => 'required|min:3|max:255',
            'branch_province' => 'required',
            'branch_city' => 'required',
            'branch_star' => 'required',
            'branch_maps_link' => 'required',
            'branch_description' => 'nullable|max:1000',
            'tags' => 'sometimes|array',
            'tags.*' => 'required|string|max:255|exists:branch_tags,id',
            'branch_phone' => 'nullable|regex:/^\+?[0-9\s\-]{7,15}$/',
            'branch_web' => 'nullable|url|max:100',
            'branch_logo' => 'nullable|image|mimes:jpeg,png,webp', 
            'branch_thumbnail' => 'nullable|image|mimes:jpeg,png,webp', 
            'branch_photos' => 'nullable|array',
            'branch_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp' 
        ],[
            'branch_photos.*.image' => 'File harus berupa gambar',
            'branch_photos.*.max' => 'Ukuran gambar maksimal 2MB', 
        ]); 
        
        try {
            
            DB::beginTransaction();

            $branch->update($validated);
            $branch->facilities()->sync($request->facilities ?? []);

            // Sync tags
            $branch->tags()->sync($request->tags ?? []);

            if ($request->hasFile('branch_logo')) {
                $this->deleteOldImage($branch->{'branch_logo'}); 
                $branch->branch_logo = $this->processAndStoreImage($request->file('branch_logo'), 'branch_logos', 'branch_logo');
                $branch->save();
            }

            if ($request->hasFile('branch_thumbnail')) {
                $this->deleteOldImage($branch->{'branch_thumbnail'}); 
                $branch->branch_thumbnail = $this->processAndStoreImage($request->file('branch_thumbnail'), 'branch_thumbnail', 'branch_thumbnail');
                $branch->save();
            }
            

            // Handle deleted photos
            if ($request->filled('deleted_photos')) {
                foreach ($request->deleted_photos as $photoId) {
                    $photo = $branch->photos()->find($photoId); // Gunakan find() agar tidak error jika ID tidak ditemukan
                    if ($photo) { // Pastikan $photo tidak null
                        $this->deleteOldImage($photo->path);
                        $photo->delete();
                    }
                }
            }

            // Add new photos
            if ($request->hasFile('branch_photos')) {
                foreach ($request->file('branch_photos') as $newPhoto) {
                    $path = $this->processAndStoreImage($newPhoto);
                    $branch->photos()->create([
                        'branch_id' => $branch->id, // Pastikan ID branch ditambahkan
                        'path' => $path
                    ]);
                    $branch->save();
                }
            } 
            
            DB::commit();

            alert()->success('Success', 'Branch Berhasil Diubah');
            return redirect('management/config/branch');

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function destroy($id){
        $branch = Branch::find($id);
        
        if (!$branch) {
            
            alert()->error('Error', 'Branch Gagal Ditemukan');
            return redirect()->back();
        }
    
        try {
            DB::beginTransaction();
    
            // Hapus setiap foto satu per satu
            foreach ($branch->photos as $photo) {
                $photo->delete();
            }
    
            // Hapus branch setelah semua foto dihapus
            $branch->delete();
    
            DB::commit();
    
            alert()->success('Success', 'Branch Berhasil Dihapus');
            return redirect('management/config/branch');
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            alert()->error('Success', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
 
}
