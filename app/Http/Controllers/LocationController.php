<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function getProvinces(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $cacheKey = 'provinces.'.md5($searchTerm);
        
        $provinces = Cache::remember($cacheKey, 60*24, function() use ($searchTerm) {
            return Province::when($searchTerm, function($query) use ($searchTerm) {
                    $query->where('province', 'like', '%'.$searchTerm.'%');
                })
                ->orderBy('province')
                ->get();
        });
        
        return response()->json($provinces);
    }

    public function getRegencies(Request $request, $province_id)
    {
        $searchTerm = $request->input('search');
        
        $regencies = Regency::where('province_id', $province_id)
            ->when($searchTerm, function($query) use ($searchTerm) {
                $query->where('regency', 'like', '%'.$searchTerm.'%');
            })
            ->orderBy('regency')
            ->get();
        
        return response()->json($regencies);
    }
}
