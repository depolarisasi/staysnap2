<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSlider;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesImageUploads; 
use Exception;
use DB;

class HomeSliderController extends Controller
{
    use HandlesImageUploads; 

    protected $imageDirectory = 'image';
    protected $imageWidth = 10000;
    protected $imageHeight = 10000;
    protected $imageQuality = 80;
    protected $imageFieldName = 'image';

    public function index()
    {
        $slider = HomeSlider::all();
        return view('setting.slider.index', compact('slider'));
    }

    public function create()
    {
        return view('setting.slider.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string', 
            'image' => 'nullable|image|mimes:jpeg,png,webp', 
        ]);
    
        try { 
            
            DB::beginTransaction();

            $slider = HomeSlider::create($validated);
            
            if ($request->hasFile('image')) {  
                $slider->image = $this->processAndStoreImage($request->file('image'), 'images', 'image');
                $slider->save();
            }
   
            DB::commit();

            alert()->success('Success', 'Slider Berhasil Dibuat');
            return redirect('management/config/slider');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        $slider = HomeSlider::find($id);
        return view('setting.slider.edit', compact('slider'));
    }

    public function update(Request $request, HomeSlider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string', 
            'image' => 'nullable|image|mimes:jpeg,png,webp', 
        ]);

        try {
            
            DB::beginTransaction();

            $slider->update($validated);
 

            if ($request->hasFile('image')) {
                $this->deleteOldImage($slider->{'image'}); 
                $slider->image = $this->processAndStoreImage($request->file('image'), 'images', 'image');
                $slider->save();
            }

             
  
            DB::commit();

            alert()->success('Success', 'Slider Berhasil Diubah');
            return redirect('management/config/slider');

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function destroy($id)
    {
        $slider = HomeSlider::find($id);
        
        if (!$slider) {
            
            alert()->error('Error', 'Slider Gagal Ditemukan');
            return redirect()->back();
        }
    
        try {
            DB::beginTransaction();
      
            $this->deleteOldImage($slider->{'image'}); 
            $slider->delete();
    
            DB::commit();
    
            alert()->success('Success', 'Slider Berhasil Dihapus');
            return redirect('management/config/slider');
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            alert()->error('Success', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
 
    }
}
